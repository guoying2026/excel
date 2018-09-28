<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class LcchnProposal extends Eloquent
{
    protected $table = 'lcchn_proposal';
    public $timestamps = true;
    protected $fillable = ['e_r_id'];
}