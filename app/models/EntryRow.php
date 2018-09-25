<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class EntryRow extends Eloquent
{
    protected $table = 'entry_row';
    public $timestamps = true;
    protected $guarded = [];  
}