<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\PermissionGroup;
use DB;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;


class RoleController extends Controller
{

    public function AllPermission(){

        $permissions = Permission::all(); 
          
        return view('admin.permission.all_permission',compact('permissions'));

    }// End Method 

    public function AddPermission(){

        $permission_groups = PermissionGroup::all();

        return view('admin.permission.add_permission', compact('permission_groups'));

    }// End Method 

    public function StorePermission(Request $request){

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);  

    }// End Method 


    public function EditPermission($id){

        $permission = Permission::find($id);
        $permission_groups = PermissionGroup::all();

        return view('admin.permission.edit_permission',compact('permission','permission_groups'));

    }// End Method 

    public function UpdatePermission(Request $request){

        $per_id = $request->id;

        Permission::find($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);  

    }// End Method 

    public function DeletePermission($id){

        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);  

    }// End Method 




    public function AllRoles(){

        $roles = Role::all();
        return view('admin.roles.all_roles',compact('roles'));

    }// End Method

    public function AddRoles(){

        return view('admin.roles.add_roles');

    }// End Method

    public function StoreRoles(Request $request){

        Role::create([
            'name' => $request->name, 
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);  

    }// End Method 

    public function EditRoles($id){

        $roles = Role::find($id);
        return view('admin.roles.edit_roles',compact('roles'));


    }// End Method 

    public function UpdateRoles(Request $request){

        $role_id = $request->id;

        Role::find($role_id)->update([
            'name' => $request->name, 
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);  

    }// End Method 

    public function DeleteRoles($id){

        Role::find($id)->delete();

        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 

    }// End Method 

    
    //////////// Add Role Permission All Mehtod ////////////////

    public function AddRolesPermission(){


        $roles = Role::all();
        $permissions = Permission::all();
        $permission_groups = PermissionGroup::all();

        return view('admin.rolesetup.add_roles_permission',compact('roles','permission_groups','permissions'));

    }// End Method 


    public function RolePermissionStore(Request $request){

        $data = array();
        $permissions = $request->permission;

        


        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

          try {
            $ins=  DB::table('role_has_permissions')->insert($data);

          } catch (\Exception $e) {
            if ( $e->getCode() =="23000"){ //Integrity constraint violation: 1062 Duplicate entry
                $notification = array(

                    'message' => 'Please Add A new Permissions Not Defind In The Role ',
                    'alert-type' => 'error'
                );
                return redirect()->route('all.roles.permission')->with($notification); 
        
        

           }
          }
 
        } // end foreach


        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with($notification); 


    }// End Method 

    public function AllRolesPermission(){

        $roles = Role::all();
        return view('admin.rolesetup.all_roles_permission',compact('roles'));

    }// End Method
    
    public function AdminEditRoles($id){

        $role = Role::find($id);
        $permissions = Permission::all();
        $permission_groups = PermissionGroup::all();

        return view('admin.rolesetup.edit_roles_permission',compact('role','permission_groups','permissions'));


    }// End Method 

    public function AdminUpdateRoles(Request $request, $id){

        $role = Role::find($id);
        $permissions = $request->permission;
        
        //  if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        // }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles.permission')->with($notification); 

    }// End Method 


    public function AdminDeleteRoles($id){

        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }// End Method 


    

  public function AllPermissionGroup(){

        $groups = PermissionGroup::all();

        return view('admin.rolesetup.all_permission_groups',compact('groups'));

    }

    public function CreatePermissionGroup(){
 

        return view('admin.rolesetup.create_permission_groups');

    }
    

    public function StorePermissionGroup(Request $request ){

            
        $request->validate([
            'name' => 'required',

        ]);

        //store the file
       $group= PermissionGroup::create([
            'name' =>$request->name,
        ]);
           
        $notification = array(
            'message' => 'Group Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission.group')->with($notification);  

    }//
    

    public function EditPermissionGroup($id){
 
        $group= PermissionGroup::find($id);

        return view('admin.rolesetup.edit_permission_groups', compact('group'));
 

    }
    
    public function UpdatePermissionGroup(Request $request ){

            
        $request->validate([
            'name' => 'required',

        ]);

        $group = PermissionGroup::find($request->id);

        $group->update([
            'name' =>$request->name,
        ]);

        $notification = array(
            'message' => 'PermissionGroup Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission.group')->with($notification);    
    }//

    public function DeletePermissionGroup($id){

        $group = PermissionGroup::find($id);
        if (!is_null($group)) {
            $group->delete();
        }

        $notification = array(
            'message' => 'PermissionGroup Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
      
    }// End Method


    public function ImportPermission(){

        return view('admin.permission.import_permission');

    }// End Method 


    public function Export(){

        return Excel::download(new PermissionExport, 'permission.xlsx');

    }// End Method

    public function Import(Request $request){

     

        try {
            Excel::import(new PermissionImport, $request->file('import_file'));
            //add the group also
        //     $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
        //     foreach ($permission_groups as $key => $value ) {
             
        //        try {
        //             PermissionGroup::create([
        //                     'name'=> $value->group_name
        //                 ]);   
        //       } catch (\Exception $e) {
        //         info("alex::: error dublicate group" . $value->group_name);

        //       }
             
        // }
           
          } catch (\Exception $e) {
         

            if ( $e->getCode() =="23000"){ //Integrity constraint violation: 1062 Duplicate entry
                $notification = array(

                    'message' => 'Please Add A new Permissions Not Defind In The Role ',
                    'alert-type' => 'error'
                );

            
                info("alex::: error dublicate group Excel::import"  );

                return redirect()->back()->with($notification);          
        

           }
          }


        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);  

    }// End Method
}
