<?php

namespace App\Models;

use App\Enums\StatusDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'type_id',
        'user_id'
    ];

    public function subtasks(){
        return $this->hasMany(Subtask::class)->where('is_delete', StatusDelete::NORMAL);
    }

}
