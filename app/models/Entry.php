<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Entry extends Eloquent
{
    protected $table = 'entry';
    public $timestamps = true;
    protected $guarded = [];
} 