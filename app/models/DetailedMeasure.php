<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class DetailedMeasure extends Eloquent
{
    protected $table = 'detailed_measure';
    public $timestamps = true;
    protected $guarded = [];
}