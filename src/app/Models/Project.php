<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'status_id',
        'title',
        'deadline',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function getDeadlineAttribute($deadline)
    {
        return Carbon::parse($deadline);
    }
}
