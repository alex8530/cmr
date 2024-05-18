<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmrRequest extends Model
{
    use HasFactory;
    protected $guarded = []; 


    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function cmr(){
        return $this->belongsTo(Cmr::class, 'cmr_id', 'id');
    }

    public function fileTrack(){
        return $this->belongsTo(FileTrack::class, 'file_track_id', 'id');
    }
}
