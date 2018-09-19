<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class DetailedMeasure extends Eloquent
{
    protected $table = 'detailed_measure';
    public $timestamps = true;
    protected $fillable = ['e_r_id','dm_no','dm_owner','compl_in','impl_date','intended_effect'];
}