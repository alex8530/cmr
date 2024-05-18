<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Cmr;

class GroupController extends Controller
{
  
    
    public function GroupAll(){

        $groups = Group::all();
        return view('admin.group.all_group',compact('groups'));
      
    }// End Method

    
    public function GroupCmrs(){

        $user = auth()->user() ;

         $cmrs =  Cmr::whereHas('owner',function($query)use($user){
                $query->where('group_id',$user->group_id);
            })->get();
       
        return view('user.my_cmrs_group',compact('cmrs'));
      
    }// End Method

    

    public function EditGroup($id){

        $group= Group::find($id);

        return view('admin.group.edit_group', compact('group'));


         
      
    }// End Method
    public function DeleteGroup($id){

        $group = Group::find($id);
        if (!is_null($group)) {
            $group->delete();
        }

        $notification = array(
            'message' => 'Group Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
      
    }// End Method

    public function CreateGroup(){

        return view('admin.group.add_group');
         
      
    }// End Method


    public function AddGroup(Request $request ){

            
        $request->validate([
            'name' => 'required',

        ]);

        //store the file
       $group= Group::create([
            'name' =>$request->name,
           

        ]);
           
        

        $notification = array(
            'message' => 'Group Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('group.all')->with($notification);  


      
    }//


    public function UpdateGroup(Request $request ){

            
        $request->validate([
            'name' => 'required',

        ]);

        $group = Group::find($request->id);

        $group->update([
            'name' =>$request->name,
        ]);
           
        

        $notification = array(
            'message' => 'Group Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('group.all')->with($notification);    
    }//


}
