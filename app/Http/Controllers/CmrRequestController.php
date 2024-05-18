<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CmrRequest;
use App\Models\FileTrack;

class CmrRequestController extends Controller
{
    //

    public function MyRequest(){

        $MyRequests = CmrRequest::where('user_id',auth()->id())->get();
         return view('user.my_cmr_requests',compact('MyRequests'));

    }


    public function RequestDetails($id){
        $CmrRequest = CmrRequest::find($id);
          
        return view('user.cmr_request_details',compact('CmrRequest'));
    }
    public function RequestUpdate(Request $request, $id){



        $CmrRequest = CmrRequest::find($id);
 //chack if has a previous one and status=rejected, so allow him to update file and status

        if( $CmrRequest->status ==='rejected'||  $CmrRequest->status ==='pending' ){

            //if approved or on progress no need to do nothing
            $rules = [
                'report_file' => 'required|file'
            ];
            $request->validate($rules);
            $file = $request->file('report_file');  
    
            $name_gen ='version_'.$CmrRequest->level.'_'.'cmr_id_'.$CmrRequest->cmr_id.'_user_'. auth()->id().'_'.date('YmdHis').'.'.$file->getClientOriginalExtension() ;
            $file->move(public_path('upload/cmr/'),$name_gen);
     
           //check if has prevois file so update it
            $fileTrack = FileTrack::where('cmr_id',$CmrRequest->cmr_id)->where('user_id',auth()->id() )->where('status','1')
            ->where('version_number',$CmrRequest->level)
            ->first() ;
           
             if(!empty($fileTrack)){
                $fileTrack->update(['status'=>'0']);
             }
             //by default the status is 1

                $file_track = FileTrack::create(['cmr_id' => $CmrRequest->cmr_id,'user_id'=>auth()->id() ,'version_number' =>$CmrRequest->level ,
                'filename' => $name_gen , 'status'=>'1']);
            
                    $CmrRequest->update(['status'=>'in_progress','file_track_id'=>$file_track->id]);
            
                    $notification = array(
                        'message' => 'Sent Successfully',
                        'alert-type' => 'success'
                    );
                    
            
                    return redirect()->route('request.details',$id)->with($notification);
    
            }
    
        
      
        $notification = array(
            'message' => 'You Cannot upload request when the status is rejected or pending  ',
            'alert-type' => 'error'
        );
         return redirect()->route('request.details',$id)->with($notification);
    }


    public function RequestAccept($id){

        $cmrRequest = CmrRequest::find($id);
        $cmr = $cmrRequest->cmr;
        if($cmrRequest->level != $cmr->current_level){
            $notification = array(
                'message' => 'Request Faild ',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $cmrRequest->update([

            'status'=>'approved'
        ]);
      
         $cmr->update([
            'current_level' => intval($cmrRequest->level) +1,
            'last_version_file_track_id'=>$cmrRequest->file_track_id
        ]);
        $notification = array(
            'message' => 'Request Approved Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }


    public function RequestDecline(Request $request , $id){

        $cmrRequest = CmrRequest::find($id)->update([
            'status'=>'rejected',
            'comment'=>$request->comment 
        ]);
      
         
        $notification = array(
            'message' => 'Request Decline Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
}
