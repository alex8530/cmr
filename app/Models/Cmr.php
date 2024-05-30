<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cmr extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];


    public function owner(){
        //cmr has one owner
        return $this->belongsTo(User::class , 'owner_id', 'id');
    }

    public function requests(){
        return $this->hasMany(CmrRequest::class,   'cmr_id', 'id');
    }
    // public function assignUser2(){
    //     return $this->belongsTo(User::class, 'assign_user_2_id','id');
    // }
    // public function assignUser3(){
    //     return $this->belongsTo(User::class, 'assign_user_3_id','id');
    // }
    // public function assignUser4(){
    //     return $this->belongsTo(User::class, 'assign_user_4_id','id');
    // }

    public function fileTrack(){
        //cmr has one owner
        return $this->belongsTo(FileTrack::class , 'last_version_file_track_id', 'id');
    }
}
