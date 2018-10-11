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
			'ref_number' => $condition['ref_number'],
			'flag' => $condition['flag']
		]);
		return $result;
	}
	//Q 400 version
	public function levelimage($condition){
		$result = DB::table('entry_row')
					->join('file','file.id','=','entry_row.file_id')
					->join('entry','entry.e_r_id','=','entry_row.id')
					->where('entry_row.org_unit','=','CHN')
					->where('file.version','=',$condition['version'])
					->where('entry_row.flag','=',$condition['flag'])
					->where('entry.column','=','Q')
					->where('entry.value_type','=','400')
					->select('entry.e_r_id AS value','entry.value AS name')
					->get();
		return $result;
	}
	//G 400 version
	public function categoryname($condition){
		$result = DB::table('entry_row')
					->join('file','file.id','=','entry_row.file_id')
					->join('entry','entry.e_r_id','=','entry_row.id')
					->where('entry_row.org_unit','=','CHN')
					->where('file.version','=',$condition['version'])
					->where('entry_row.flag','=',$condition['flag'])
					->where('entry.column','=','G')
					->where('entry.value_type','=','400')
					->select('entry.e_r_id AS value','entry.value AS name')
					->get();
		return $result;
	}
	/**
	 * 根据文件id查询文件信息
     */
	public function entry_row($condition){
		$result = DB::table("entry_row")
					->join("entry","entry_row.id","=","entry.e_r_id")
					->join("file","entry_row.file_id","=","file.id")
					->where("file.id",'=',$condition['id'])
					->whereIn("entry.column",['Q','AF','AE','A','B','F','G','AC','C'])
					->where("entry.value_type",'=','400')
					->where("entry_row.parent_id",'=','0')
					->select('entry_row.file_id','file.version','entry.e_r_id','entry_row.ref_number','entry.column','entry.value')
					->get();
		return $result;
	}
	public function entry_rows(){
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
	/**
	 * 根据file_id查询entry_row的主键id
     */
	public function search_id($condition){
		$result = DB::table('entry_row')
					->where("entry_row.file_id",'=',$condition['id'])
					->where("parent_id",'=',0)
					->select('id','file_id','parent_id')
					->get();
		return $result;
	}
	public function delete(){
		$result = DB::table('entry_row')->truncate();
		return $result;
	}
}