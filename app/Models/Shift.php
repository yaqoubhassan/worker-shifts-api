<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['worker_id', 'start_time', 'end_time'];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
