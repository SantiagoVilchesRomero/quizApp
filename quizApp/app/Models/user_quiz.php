<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_quiz extends Model
{
    use HasFactory;

    protected $table="user_quizs";
    protected $primaryKey="id";

    protected $fillable=['user_id','quiz_id','std_status','quiz_joined'];
}
