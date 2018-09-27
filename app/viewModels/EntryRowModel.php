<?php
use Illuminate\Database\Capsule\Manager as DB;

class EntryRowModel extends Controller
{
	/**
	 * 向entry表中批量存取表格基本信息
     */
	public function create_entry_row($condition){
		$result = $this->model('EntryRow')::updateOrCreate([
			'file_id' => $condition['file_id'],
			'row' => $condition['row']
		],[
			'parent_id' => $condition['parent_id'],
			'virtual_row' => $condition['virtual_row'],
			'org_unit' => $condition['org_unit'],
			'ref_number' => $condition['ref_number']
		]);
		return $result;
	}

	/**
	 * 根据文件id查询文件信息
     */
	public function entry_row(){
		$result = DB::table("entry_row")
					->join("entry","entry_row.id","=","entry.e_r_id")
					->join("file","entry_row.file_id","=","file.id")
					->whereIn("entry.column",['C','G'])
					->where("entry.value_type",'=','400')
					->where("entry_row.parent_id",'=','0')
					->select('entry_row.file_id','file.version','entry.e_r_id','entry_row.ref_number','entry.value')
					->get();
		return $result;
	}
	/**
	 * 根据e_r_id查询detailed,联查3张表
     */
	public function substance($condition){
		$result = DB::table("entry_row")
					->join("detailed_measure","entry_row.id",'=','detailed_measure.e_r_id')
					->join("detailed",'detailed_measure.id','=','detailed.d_m_id')
					->whereIn("entry_row.ref_number",$condition)
					->where("entry_row.parent_id",'=','')
					->get();
		return $result;
	}
	/**
	 * 根据e_r_id查询entry,联查2张表
     */
	public function entryd_ae($condition){
		$result = DB::table('entry_row')
					->join("entry","entry_row.id",'=','entry.e_r_id')
					->whereIn("entry.column",['D','AE'])
					->whereIn("entry_row.ref_number",$condition)
					->where("entry_row.parent_id",'=','')
					->get();
		return $result;
	}
	public function update_comment($condition){
		$result = $this->model('EntryRow')::where('id',$condition['e_r_id'])->update(['comment'=>$condition['comment']]);
		return $result;
	}
}