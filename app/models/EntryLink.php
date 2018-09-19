<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class EntryLink extends Eloquent
{
    protected $table = 'entry_link';
    public $timestamps = true;
    const CREATED_AT = 'creatd_time';
    const UPDATED_AT = 'modified_time';
    protected $guarded = ['comment'];
} 