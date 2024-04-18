<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
    protected $table = 'task_request';
    use HasFactory;
    protected $fillable = ['user', 'task'];

}