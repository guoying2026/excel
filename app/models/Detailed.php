<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Detailed extends Eloquent
{
    protected $table = 'detailed';
    public $timestamps = true;
    protected $guarded = [];
}