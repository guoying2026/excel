<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class EntryRow extends Eloquent
{
    protected $table = 'entry_row';
    public $timestamps = true;
    protected $fillable = ['file_id','row','virtual_row','parent_id','org_unit','ref_number'];  
}