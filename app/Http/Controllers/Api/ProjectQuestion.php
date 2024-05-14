<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectQuestionCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectQuestion extends Controller
{
    public function index()
    {
        $query = \App\Models\ProjectQuestion::query()->with('project', 'userBelongs')->where('user_id', Auth::user()->id);
        $questions = $query->latest()->public()->paginate(3);
        return (new ProjectQuestionCollection($questions));
    }

    public function create(Request $request){
        $this->validate($request,[
            'project_id'=>'required',
            'question' => 'required',
        ]);

        $data= $request->all();
        $data['user_id'] = Auth::user()->id;
        $projectQuestion = \App\Models\ProjectQuestion::create($data);
        return \App\Http\Resources\ProjectQuestion::make($projectQuestion)->additional(['message' => 'Question submit successfully']);
    }


    public function getQuestionByProject($projectId){
        $query = \App\Models\ProjectQuestion::query()->with('project', 'userBelongs')
            ->where('project_id',$projectId);
        $questions = $query->latest()->public()->get();
        return (new ProjectQuestionCollection($questions));
    }
}
