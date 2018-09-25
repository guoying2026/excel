<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class File extends Eloquent
{
    protected $table = 'file';
    public $timestamps = true;
    protected $guarded = [];
}