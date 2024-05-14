<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectQuestionCollection;
use App\Http\Resources\ProjectViewCollection;
use App\Models\Category;
use App\Models\Location;
use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Models\ProjectQuestion;
use App\Models\ProjectView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{

    public function getFavorite()
    {
        $projectsIds = Auth::user()->projectFavorites()->pluck('project_id');
        $projects = Project::with('category')->whereIn('id', $projectsIds)->paginate(5);
        return (new ProjectCollection($projects));
    }

    public function favorite(Request $request, $project_id)
    {
        $favorite = ProjectFavorite::create([
            "user_id" => Auth::user()->id,
            "project_id" => $project_id,
            "status" => "active",
        ]);

        $project = Project::whereId($project_id)->with('category', 'userBelongs', 'questions', 'bids')->first();

        return (new \App\Http\Resources\Project($project));
    }

    public function Unfavorite(Request $request, $project_id)
    {
        $favorite = ProjectFavorite::where("user_id", Auth::user()->id)->where(
            "project_id", $project_id)->delete();

        return response()->json([
            'Unfavorite' => true,
            'project_id' => $project_id,
        ]);
    }

    public function getProjectViewed()
    {
        $projectsIds = Auth::user()->projectViews()
            ->orderBy('id', 'desc')
            ->pluck('project_id');

        $projects = Project::with('category')
            ->whereIn('id', $projectsIds)
            ->paginate(5);
        return (new ProjectCollection($projects));
    }

    public function getViewed()
    {
        $projectViews = ProjectView::query()->where('user_id', Auth::user()->id)
            ->whereRaw('id IN (SELECT MAX(id) FROM project_views WHERE user_id = ? GROUP BY project_id)', Auth::user()->id)
            ->has('project')
            ->with('project')
            ->with('project.category')
            ->orderBy('id', 'desc')
            ->paginate(5);
        return (new ProjectViewCollection($projectViews));
    }

    public function getQuestion()
    {
        $query = ProjectQuestion::query()->with('project', 'userBelongs')->where('user_id', Auth::user()->id);
        $questions = $query->latest()->public()->paginate(3);
        return (new ProjectQuestionCollection($questions));
    }

    public function getProjects(Request $request)
    {
        $query = Project::query();

        $query = $query->has('category')->with('category', 'userBelongs', 'projectrfpfileASCOrder', 'projectaddendumASCOrder');

        if ($request->search) {
                $query = $query->where('project_number', 'Like', '%' . $request->search . '%')
                    ->orWhere('name', 'Like', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query = $query->where('category_id', $request->category_id);
        }

        if ($request->state) {
            $query = $query->whereHas('userBelongs', function ($q) use ($request) {
                return $q->where('state', $request->state);
            });
        }

        if ($request->county) {
            $query = $query->whereHas('userBelongs', function ($q) use ($request) {
                return $q->where('county', $request->county);
            });
        }


        $isQueryExpired = true;
        if ($request->dueby) {
            if ($request->dueby == 1) {

            } elseif ($request->dueby == 5) {
                $query = $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(7));
            } elseif ($request->dueby == 10) {
                $query = $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(30));
            } elseif ($request->dueby == 15) {
                $query = $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(60));
            } elseif ($request->dueby == 20) {
                $isQueryExpired = false;
                $query = $query->whereDate('deadline_date', '<=', Carbon::now());
            } elseif ($request->dueby == 0) {
                $isQueryExpired = false;
                $query = $query->whereDate('public_date', ">", Carbon::now());
            }
        }
        if ($isQueryExpired) {

            $query = $query->where("public_date", "<=", date("Y-m-d h:i:s"))
                ->where("deadline_date", ">=", date("Y-m-d"))
                ->whereRaw('DATE_ADD(deadline_date, INTERVAL deadline_beyond DAY)');

        }

        $filters = [
            'dueBy' => $this->dueByOptions(),
            'states' => Location::getStates(),
            'county' => $request->state ? Location::getCounties($request->state) : [],
            'categories' => Category::all()->pluck('name', 'id'),
        ];
        $projects = $query->paginate(15);
        $data["projects"] = (new ProjectCollection($projects))->response()->getData(true);
        $data["filters"] = $filters;
        return \response()->json($data);

    }

    public function getCountyByState($state)
    {
        $counties = Location::getCounties($state);
        if (!$counties) {
            throw ValidationException::withMessages(['message' => 'data does not ']);
        }
        return \response()->json(['counties' => $counties]);
    }

    public function dueByOptions()
    {
        $data = [
//            'All Projects' => 1,
            'Less than 7 days' => 5,
            'Less than 30 days' => 10,
            'Less than 60 days' => 15,
            'Expired' => 20,
        ];
        if (Auth::user()->hasRole(['admin', 'superadmin'])) {
            $data['scheduled'] = 0;
        }
        return $data;
    }

    public function show($id)
    {
        ProjectView::create([
            'project_id' => $id,
            'user_id' => Auth::user()->id
        ]);
        $user = Auth::user();
        $project = Project::whereId($id)
            ->with('category', 'userBelongs', 'questions', 'vendorBids', 'vendorBids.attachments')->first();

        return (new \App\Http\Resources\Project($project));
    }


}
