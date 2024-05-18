<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache; 
use Spatie\Permission\Traits\HasRoles;
use DB;
 

class User extends Authenticatable
{
    use HasFactory, Notifiable; 
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = []; 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function cmrs():HasMany{
        return $this->hasMany(Cmr::class,'owner_id');
    }

    public function requests():HasMany{
        return $this->hasMany(CmrRequest::class,   'user_id', 'id');
    }

     // User Active Now
     public function UserOnline(){
        return Cache::has('user-is-online' . $this->id);
    }

    public function group (){
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }


    public static function getpermissionByGroupName($group_name){

        $permissions = DB::table('permissions')
                        ->select('name','id')
                        ->where('group_name',$group_name)
                        ->get();

                        return $permissions;
    } // End Method 


    public static function roleHasPermissions($role,$permissions){

        $hasPermission =  true;
        foreach ($permissions as  $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
            }
            return $hasPermission;
        }

    }// End Method 


    // public function can($ability, $arguments = []) 
    // { 
    //     return $this->hasPermissionTo($ability);
    // }
    
}
