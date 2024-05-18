<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTanleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('groups')->insert([

            [
                'name' => 'payment',
               
               
            ] ,
            [
              
                'name' => 'network',
               
            ] 
            
        ]);


        DB::table('users')->insert([

            [
                'name' => 'Super',
                'username' => 'super',
                'email' => 'super@gmail.com',
                'password' => Hash::make('123'), 
                'active' => '1',
                'group_id'=>'1'
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'), 
                'active' => '1',
                'group_id'=>'1'
            ],
           
            [
                'name' => 'User1',
                'username' => 'user1',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('123'), 
                'active' => '1',
                'group_id'=>'2'
            ],
            [
                'name' => 'User2',
                'username' => 'user2',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('123'), 
                'active' => '1',
                'group_id'=>'2'
            ],
            [
                'name' => 'User3',
                'username' => 'user3',
                'email' => 'user3@gmail.com',
                'password' => Hash::make('123'), 
                'active' => '1',
                'group_id'=>'2'
            ]
            
        ]);

   
        // DB::table('permission_groups')->insert([

        //     [
        //         'name' => 'all_user',
            
        //     ] ,
        //     [
        //         'name' => 'all_cmr',
            
        //     ]  
        // ]);

//  // Reset cached roles and permissions
//  app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

 
//         Permission::create([
//             'name' => 'edit',
//             'group_name' => 'all_user',
//         ]);

//         Permission::create([
//             'name' => 'delete',
//             'group_name' => 'all_cmr',
//         ]);


        
       
        // Role::create([
        //     'name' => 'super', 
        // ])->givePermissionTo(Permission::all());


        // Role::create([
        //     'name' => 'admin', 
        // ])->givePermissionTo(Permission::all());

        
        // Role::create([
        //     'name' => 'user', 
        // ]) ->givePermissionTo([
        //     'dashboard.menu',
        //     'cmr.create',
        //     'completed.cmr.menu',
        //     'pending.cmr.menu',
        //     'pending.cmr.details',
        //     'pending.cmr.delete',
        //     'pending.cmr.edit',
        //     'pending.cmr.request.accept',
        //     'pending.cmr.request.decline',
        //     'pending.cmr.complete',
        //     'my.request.menu',
        //     ]
        
        // );

        Role::create([
            'name' => 'super', 
        ]);
        Role::create([
            'name' => 'admin', 
        ]);
        Role::create([
            'name' => 'user', 
        ]);
        User::find('1')->assignRole('super');
        User::find('2')->assignRole('admin');
        User::find('3')->assignRole('user');
        User::find('4')->assignRole('user');
        User::find('5')->assignRole('user');
    }
}
