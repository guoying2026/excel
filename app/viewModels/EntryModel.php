<?php
use Illuminate\Database\Capsule\Manager as DB;
class EntryModel extends Controller
{
	/**
	 * 向entry表中批量存取表格基本信息
     */
	public function create_entry($condition){
		$result = $this->model('Entry')::create($condition);
		return $result;
	}
	/**
	 * 向entry表中提取表格基本信息
	 */
	public function entry($condition){
		$result = DB::table('entry')
					->where("e_r_id","=",$condition['e_r_id'])
					->get();
		return $result;
	}
}