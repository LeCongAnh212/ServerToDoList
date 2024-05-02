<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTypeTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'type_task_id',
    ];
}
