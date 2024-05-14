<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectBidCollection;
use App\Http\Resources\ProjectCollection;
use App\Models\ProjectBid;
use App\Models\ProjectBidAttachment;
use Carbon\Carbon;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\throwException;

class BidSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ProjectBid::query()
            ->where('user_id', Auth::user()->id)
            ->with('project', 'attachments');

        $bids = $query->latest()->withdraw(false)->paginate(20);

        return (new ProjectBidCollection($bids));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category1' => 'required',
            'base_price' => 'required_if:category1,==,0',
            'contingency_fee' => 'required_if:category1,==,0',
            'term_of_contract_month' => 'required_if:category1,==,1',
            'monthly_cost' => 'required_if:category1,==,1',
            'monthly_tax_cost' => 'required_if:category1,==,1',
            'non_recurring_cost' => 'required_if:category1,==,1',
            'project_id' => 'required',
            'file' => 'required|file',
            'attachments.*' => 'required'
        ]);
        $request['user_id'] = Auth::user()->id;

        if ($request->hasFile('file')) {
            $request['url'] = $request->file->store(  'bid/'.$request->user()->id, 's3');
            if ($request['url']) {
                $request['label'] = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);
            }
        }

        $bid = ProjectBid::create($request->except('file'));
        if (!$bid) {
            throw ValidationException::withMessages(['message' => 'OOP something went wrong']);
        }

        foreach ($request->attachments as $index => $file) {
            if ($index != 0) {
                ProjectBidAttachment::create([
                    'label' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
//                'url' =>  $file->move(public_path().'/', time().'.'.$file->getClientOriginalExtension()),
                    'url' => $request->attachments[$index]->store('bid_attachment/'.$request->user()->id, 's3'),
                    'project_bid_id' => $bid->id,
                ]);
            }
        }

        $bid = ProjectBid::find($bid->id);
        $bid->attachments;
        $bid = new \App\Http\Resources\ProjectBid($bid);


        return response()->json(['bid' => $bid, 'status' => true, 'message' => 'Bid successfully submitted']);
    }

    /**
     * @throws ValidationException
     */
    public function withdraw(Request $request)
    {
        $this->validate($request, [
            'project_bid_id' => 'required'
        ]);
        $projectBid = ProjectBid::find($request->project_bid_id);
        if (Carbon::now()->gt($projectBid->project->deadline_datetime)) {
            throw ValidationException::withMessages(['Bid cannot be withdraw after deadline']);
        }
        $projectBid->is_withdraw = true;
        $projectBid->save();

        return response()->json(['message' => 'withdrawn successful', 'status' => true]);
    }
}
