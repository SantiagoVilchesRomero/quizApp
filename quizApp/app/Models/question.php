<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiestion extends Model
{
    use HasFactory;

    protected $table="question";

    protected $primaryKey="id";
    protected $fillbale=['quiz_id','questions','ans','options','status'];
}
