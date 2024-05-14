<?php

namespace App\Http\Controllers;

use App\Events\EventProjectUpdated;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Location;
use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Models\ProjectView;
use App\Models\User;
use App\Notifications\NotificationProjectUpdated;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use stdClass;

class TestController extends Controller
{
    
    public function testpost(Request $Request) {
        exit;
        $Validator = Validator::make($Request->all(), [
            'username' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);


        $inputs = $Request->input();
        $error_keys = array_keys($Validator->errors()->toArray());
        return response()->json(array_keys($Validator->errors()->toArray()));


        return response()->json(["failed" => true, "errors" => array_keys($Validator->errors()->toArray())]);
        if ($Validator->fails()) {
            return response()->json(["failed" => true, "errors" => __(implode("<br>", $Validator->errors()->all()))]);
        }
        echo response()->json(__("Your  updated!"));

        exit;

        echo 44;
        exit;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
      ]);
      
      if ($validator->fails()) {
         return response()->json(["failed" => true, "errors" => $validator->errors()], 404);
      }

        if (Hash::check('plain-text', Auth::user()->password)) {
        }


        validator(request()->all(), [
            'email' => 'required',
        //    'address' => 'required'
        ])->validate();
        echo response()->json(__("Your  updated!"));
    }



    public function test(Request $request) 
    {
        $user = User::find(1);
        
        (new MailMessage)
    ->greeting('Hello ' . $user->email)
    ->greeting('Hello ' . $user->email)
    ->line('Test Project Name has been updated!')
    ->action('View Project', '/resources/projects/222222')
    ->line('Thank you for using our application!');

        echo 33; exit;

        echo Project::where("public_date", "<=", date("Y-m-d h:i:s"))
            ->where("deadline_date", ">=", date("Y-m-d"))
            ->whereRaw('DATE_ADD(deadline_date, INTERVAL deadline_beyond DAY)')
            ->toSql();
        $project = Project::where("public_date", "<=", date("Y-m-d h:i:s"))
            ->where("deadline_date", ">=", date("Y-m-d"))
            ->whereRaw('DATE_ADD(deadline_date, INTERVAL deadline_beyond DAY)')
            ->get();
        print_r($project);
            exit;
        ProjectView::create([
            "user_id" => 4,
            "project_id" => 1111,
        ]);
        echo config('nova.tableStyle'); exit;
        $counties = Location::getCounties('MI');
        foreach($counties as $county_id => $county_name) {
            $return[] = ['value' => $county_id, 'display' => $county_name];
        }
        print_r($return);

    exit;
        $ProjectFavorite = ProjectFavorite::where("user_id", 355)
            ->where("project_id", 502472)->first();
        if($ProjectFavorite && $ProjectFavorite->status == "active") {
            // unfavorite
        }
        else {
            // favorite
            return true;
        }

        echo config('app.timezone'); exit;

    //    $project = Project::where("id", 50230)->with('fans.user')->first();
        EventProjectUpdated::dispatch(50230);
exit;
        foreach($project->fans as $fan) {
            $users[] = $fan->user;
        }
        Notification::send($users, new NotificationProjectUpdated($project));
        exit;

        $project = Project::where("id", 50029)->with('fans.user')->first();
        event(new EventProjectUpdated($project));
        echo 'event';
        exit;
        foreach($project->fans as $fan) {
            $users[] = $fan->user;
        }
        Notification::send($users, new NotificationProjectUpdated($project));
//        Notification::send($users, new NotificationProjectUpdated($project));
        print_r($users); exit;
        
            print_r($fan->user); exit;
            exit;
            $fan->user->notify(new NotificationProjectUpdated($fan->user, $project));


            print_r($fan); exit;
            $fans[] = ["name" => $fan->user->name ?? "User", "email" => $fan->user->email];

        $user->notify(new NotificationProjectUpdated($project, $fans));
        echo "notifications sent";
exit;
        // create queue


        print_r($fans); exit;
        print_r($project->fans); exit;


        $fans = Project::where("id", 50029)->with([
            'fans:user_id,project_id' => function($query) {

            }
        ])->get()->toArray();
        
    //    DB::raw();
        print_r($fans); exit;


    (new MailMessage)
    ->greeting('Hello ' . $user->email)
    ->greeting('Hello ' . $user->email)
    ->line($project->name . ' has been updated!')
    ->action('View Project', Nova::path() . '/resources/projects/' .$project->id)
    ->line('Thank you for using our application!');

        echo 33; exit;
        $User = User::find(350);
        echo $User->projectViews; exit;

        $User->projects()->each(function($project) {
            $project->delete();
        });
        
        exit;

        $counties = Location::createCountiesByState();
        exit;
        $counties = Location::createCounties();
        
        if(Auth::user()->hasRole(["superadmin"])) {
            echo 33; exit;
        }
        echo User::where('type', 'vendor')->get()->random()->id;

        exit;
        print_r(Location::getStates());
        $state = Arr::random(array_keys(Location::getStates()));
        echo Arr::random(array_keys(Location::getCounties($state)));
        exit;
        print_r($request->input('password'));
//        print_r($request->all());
        if (!Hash::check($request->input('password'), 'password')) {
            echo response()->json(__("oh no!")); exit;
        }

        exit;
        echo Auth::user()->password;
        exit;
        if(request()->validate([
        //    'name' => 'required|string',
            'email' => 'required|email',
            'first_name' => 'required|string',
        ])) {
            echo response()->json(__("Failed validation!"));
        }
        echo response()->json(__("Your  updated!"));

        exit;
        print_r(array_flip(Location::getStates())); exit;

//        array_map(fn() => , Location::getStates());

        $states = Location::getStates();
        foreach($states as $state_id => $state_name) {
            $options[$state_name] = $state_id;
        }

        $ProjectView = ProjectView::find(1)->user->name;
        print_r($ProjectView); die();

        $uri = $request->path();

        $counties = Location::createCounties();
        $counties = Location::getCounties("MI");
        print_r($counties);
        echo 'finished';
        exit;

        $admin = Client::first();
        print_r($admin); exit;

        $admin->impersonate($user);

        exit;


        $counties = Location::getCounties("AK");
        print_r($counties);
        echo 'finished';
        exit;

        echo Auth::user()->id;
        Auth::user()->assignRole('superadmin');
        if(Auth::user()->hasRole('superadmin')) {
            echo 22; exit;
        }
        echo 33; exit;
        exit;
        $user_id = User::get()->random()->id;
        $User = User::where("id", $user_id)->first();
        print_r($User->projects);
        exit;


        $Project = Project::get()->random()->id;
        print_r($Project);
        exit;
        
        $User = User::whereRaw("id > 1")->get()->random()->id;
        print_r($User);
    }

}
