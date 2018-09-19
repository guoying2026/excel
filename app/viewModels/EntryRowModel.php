<?php
use Illuminate\Database\Capsule\Manager as DB;

class EntryRowModel extends Controller
{
	/**
	 * 向entry表中批量存取表格基本信息
     */
	public function create_entry_row($condition){
		$result = $this->model('EntryRow')::create($condition);
		return $result;
	}
	/**
	 * 根据文件id查询文件信息
     */
	public function entry_row($condition){
		$result = DB::table("entry_row")
					->join("entry","entry_row.e_r_id","=","entry.e_r_id")
					->whereIn("entry_row.file_id",$condition)
					->where("entry.value_type",'=','400')
					->where("entry_row.parent_id",'=','0')
					->select('entry_row.file_id','entry_row.org_unit','entry_row.ref_number','entry.e_id','entry.e_r_id','entry.column','entry.value','entry.value_type')
					->get();
		return $result;
	}
}