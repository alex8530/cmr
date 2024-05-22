<?php

namespace App\Http\Controllers;

use App\Models\Cmr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use App\Enums\PermissionEnum;

class AdminController extends Controller
{
    //

    public function AdminDashboard (){

//        dd(auth()->user()->notifications  );


        $allCmr = Cmr::all();
        $allUsers = User::all();
        $completeCmr = Cmr::where('status','complete')->get();
        $pendingCmr = Cmr::where('status','pending')->get();
        return view('admin.index',compact('allUsers','allCmr','pendingCmr','completeCmr'));
    }

    public function AdminRegister(): View
    {
        return view('admin.admin_register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function AdminSignup(Request $request): RedirectResponse
    {
    //    dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'password' => ['required', 'confirmed'],
             'username' => ['required' ],
             'phone' => ['required' ],


        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' =>  $request->address,
            'password' => Hash::make($request->password),
        ])->assignRole('user');

        //assign default role
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard', absolute: false));
    }




    public function AdminLogout (Request $request ){

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }


    public function AdminLogin ( ){
// dd("asdsd");

        return view('admin.admin_login');
    }

    public function AdminProfile (Request $request ){
        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('admin.admin_profile',compact('profileData'));
    }
    public function AdminProfileStore (Request $request ){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
           $file = $request->file('photo');
           @unlink(public_path('upload/admin_images/'.$data->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function AdminChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));

    }// End Method

    public function UsersAll(){


        $users = User::all();
        return view('admin.user_all',compact('users'));
        // return view('admin.test',compact('users'));

    }// End Method

    public function UpdateUserStatus(Request $request){

        $user_id = $request->input('user_id');
        $isChecked = $request->input('is_checked','0');

        $user= User::find($user_id);
        if ($user) {
            $user->active = $isChecked;
            $user->save();
        }

        return response()->json(['message' => 'User Status Updated Successfully']);

    }// End Method
    public function AdminPasswordUpdate(Request $request){

        /// Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        /// Update The new Password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);

    }// End Method

    public function AllAdmin(){

        // $alladmin =User::role('Admin')->get();
        $alladmin =User::all();

        return view('admin.manageAdmin.all_admin',compact('alladmin'));

    }// End Method
    public function AddAdmin(){

        $roles = Role::all();
        return view('admin.manageAdmin.add_admin',compact('roles'));

    }// End Method

    public function StoreAdmin(Request $request){

        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->active = '1';
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);

    }// End Method


    public function EditAdmin($id){

        $user = User::find($id);
        $roles = Role::all();
        return view('admin.manageAdmin.edit_admin',compact('user','roles'));

    }// End Method

    public function UpdateAdmin(Request $request,$id){

        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
         $user->active = '1';
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'Admin Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);

    }// End Method

    public function DeleteAdmin($id){

        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => 'Admin Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }// End Method


}
