<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class File extends Eloquent
{
    protected $table = 'file';
    public $timestamps = true;
    protected $fillable = ['version','filepath','field_row','field_num','measures_column','value_row_start'];
}