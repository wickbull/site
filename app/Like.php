<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = array('id','id_parent','ip');
}
