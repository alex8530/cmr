<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\CmrComplete;
use App\Notifications\CmrRequestCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
 use App\Models\Cmr;
 use App\Models\CmrRequest;
use App\Models\FileTrack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CmrCreatedMail;
use Illuminate\View\View;

// https://arjunamrutiya.medium.com/laravel-file-storage-a-beginners-guide-a41cbbb0ca25

class CmrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }
    public function PendingCmr(){

    //    if(auth()->user()->hasRole('user')){
        // $pending_cmrs=  Cmr::where('status', 'pending')->where('owner_id',auth()->user()->id)->get();
        // dd($pending_cmrs);

    //    }elseif(auth()->user()->hasAnyRole(['super','admin'])){
        $pending_cmrs=  Cmr::where('status', 'pending')->get();
        // dd($pending_cmrs);
    //    }
       return view('admin.cmr_pending', compact('pending_cmrs'));
    }

    public function MyPendingCmr(){

     $pending_cmrs=  Cmr::where('status', 'pending')->where('owner_id',auth()->user()->id)->get();

           return view('admin.cmr_pending', compact('pending_cmrs'));
    }



    public function CompltedCmr(){

        $complete_cmrs=  Cmr::where('status', 'complete')->get();
         return view('admin.cmr_complete', compact('complete_cmrs'));
     }

    public function MyCompleteCmr(){

        $complete_cmrs=  Cmr::where('status', 'complete')->where('owner_id',auth()->user()->id)->get();
         return view('admin.cmr_complete', compact('complete_cmrs'));
     }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.cmr_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'report_file' => 'required|max:5000',
            'title' => 'required',

        ]);

        //store the file
       $cmr= Cmr::create([
            'title' =>$request->title,
            'description' =>$request->description,
            'request_date' =>$request->request_date,
            //  'report_file' => $name_gen,
            'owner_id' => $request->owner_id,
           'changed_by'=>auth()->user()->name

        ]);


        $file = $request->file('report_file');
        // $name_gen ='version_'.'0'.'_'.'cmr_id_'.$cmr->id.'_user_'. auth()->id() .'_'.  hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $name_gen ='version_0_'.'cmr_id_'.$cmr->cmr_id.'_user_'. auth()->id().'_' . date('YmdHi').'.'.$file->getClientOriginalExtension() ;

        $file->move(public_path('upload/cmr/'),$name_gen);

        //add to FileTrack Model Also
        $file_track_id = FileTrack::create([
         'cmr_id'=>$cmr->id,
         'filename'=>$name_gen,//update path
         'version_number'=>'0',
         'user_id'=>auth()->id(),
         'status'=>'1'
        ])->id;


        foreach ($request->users_id as $key => $value) {
            CmrRequest::create([
                'level'=>$key+1,
                'cmr_id'=>  $cmr->id ,
                'user_id'=>  $value ,
                // 'file_track_id'=>$file_track_id will update later by user
            ]);
        }

        //send Email
        $data = [

            'cmr_title'=>$cmr->title,
            'name' =>  $cmr->owner->name,
            'email' => $cmr->owner->email,
       ];

//       Mail::to($data['email'])->send(new CmrCreatedMail($data));
       /// End Send email to student ///

       $user =$cmr->owner;
        Notification::send($user,new CmrComplete($cmr->title));

        //send also for the assignee users
        $assigneeUsers = User::whereIn('id',$request->users_id)->get();
//        info("alex",$assigneeUsers->toArray());
        Notification::send($assigneeUsers,new CmrRequestCreated($cmr->title));


        $notification = array(
            'message' => 'CMR Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.dashboard')->with($notification);


    }

    /**
     * Display the specified resource.
     */
    public function DetailsCmr(string $id)
    {
        $cmr = Cmr::find($id);


        return view ('admin.cmr_details', compact('cmr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cmr= Cmr::find($id);
        return view('admin.cmr_edit', compact('cmr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            // 'report_file' => 'required|max:5000',
            'title' => 'required',
            'description' => 'required',
            'request_date' => 'required',

        ]);

        $file = $request->file('report_file');
        $cmr =Cmr::find($request->cmr_id);

        // if( $cmr->status != "pending" ){
            //thats means no one apply any request
            $requestsCount=CmrRequest::where('cmr_id',$cmr->id)->whereIn('status',['approved','in_progress'])->count();

        if( $requestsCount>0 ){

            $notification = array(
                'message' => 'There is One User Request At Least',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);

        }


        if( $file){

        // $name_gen ='version_'.'0'.'_'.'cmr_id_'.$cmr->id.'_user_'. auth()->id() .'_'.  hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $name_gen ='version_0_'.'cmr_id_'.$cmr->id.'_user_'. auth()->id().'_' . date('YmdHis').'.'.$file->getClientOriginalExtension() ;

        $file->move(public_path('upload/cmr/'),$name_gen);


          //check if has prevois file so update it
          $oldFileTrack = FileTrack::where('cmr_id',$cmr->id)
        //   ->where('user_id',auth()->id() ) because we have admin or owner !! we dont know who update it
          ->where('status','1')
          ->where('version_number','0')->first() ;

          if(!empty($oldFileTrack)){
             $oldFileTrack->update(['status'=>'0']);
          }


        //add to FileTrack Model Also
        $file_track_id = FileTrack::create([
         'cmr_id'=>$cmr->id,
         'filename'=>$name_gen,//update path
         'version_number'=>'0',
         'user_id'=>auth()->id(),
         'status'=>'1'
        ])->id;


        }

       $cmr->update([
            'title' =>$request->title,
            'description' =>$request->description,
            'request_date' =>$request->request_date,
            'changed_by'=>auth()->user()->name


        ]);


        $notification = array(
            'message' => 'CMR Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
         Cmr::find($id)->delete();

            $notification = array(
                'message' => 'Cmr Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

    }
    public function DownloadCmr(string $filename)
    {
        //
        return response()->download(public_path('upload/cmr/'.$filename));
    }


    public function MyRequest():View{

        $MyRequests = CmrRequest::where('user_id',auth()->id());
        return view('admin.cmr_requests',compact('MyRequests'));

    }


    public function MakeCmrComplete(string $id){

        $cmr = Cmr::find($id);


        $countAllRequest =  $cmr->requests->count();
        $approvedRequest = $cmr->requests()->where('status','approved')->get()->count();

        $isAbleToComplete =  $countAllRequest === $approvedRequest ;

        if(!$isAbleToComplete){

            $notification = array(
                'message' => 'Unable To Complete The CMR',
                'alert-type' => 'error'
            );
            dd(  $notification);
            return redirect()->back()->with($notification);

        }

        $cmr->status ='complete';
        $cmr->save();



        $notification = array(
            'message' => 'CMR Completed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);



}

    public function MarkAsRead(Request $request, $notificationId){

        $user = Auth::user();
        $notification = $user->notifications()->where('id',$notificationId)->first();

        if ($notification) {
            $notification->markAsRead();

        }

        return response()->json(['count' => $user->unreadNotifications()->count()]);

    }// End Method


}
