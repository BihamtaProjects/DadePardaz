<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Notifications\ApplicationRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationsController extends Controller
{
    public function sendNotification($application)
    {

            $user = User::where('id',$application->user_id)->first();
//            $user->notify( new ApplicationRejected() );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::latest()->paginate(20);
        return view('admin.index',compact('applications'));
    }
    /**
     * Display a listing of the resource.
     */
    public function userDashboard()
    {
        $user = Auth::user();
        $applications = Application::where('user_id',$user->id)->latest()->paginate(20);
        return view('dashboard',compact('applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        return view('admin.editRequest', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $request->validate([
            'admin_id' => 'required',
            'admin_description' => 'required',
            'status' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $application->update($request->input());
            if ($application->getRawOriginal('status') == 0) {
                $this->sendNotification($application);
            }

            DB::commit();


        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->back();
        }

        return redirect()->route('admin.applications.index');

    }

}
