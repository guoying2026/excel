<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Detailed extends Eloquent
{
    protected $table = 'detailed';
    public $timestamps = true;
    protected $fillable = ['d_m_id','detailed_measure','status_comment'];
}