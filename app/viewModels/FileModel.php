<?php
use Illuminate\Database\Capsule\Manager as DB;

class FileModel extends Controller
{
	/**
	 * 向file表中存取文件基本信息
     */
	public function c_or_u_file($condition){
		$result = $this->model('File')::updateOrCreate([
			'version' => $condition['version'],
			'filepath' => $condition['filepath']
		],[
			'flag' => $condition['flag'],
			'field_row' => $condition['field_row'],
			'field_num' => $condition['field_num'],
			'measures_column' => $condition['measures_column'],
			'value_row_start' => $condition['value_row_start']
		]);
		return $result;
	}
	public function file_version(){
		$result = DB::table('file')
					->where('flag','=','aggregated')
					->select('id','version')
					->get();
		return $result;
	}
	//report查询信息,最多能看1个季度
	public function new_version(){
		$result = DB::table('file')
					->groupby('version')
					->select('id','version')
					->limit(1)
					->get();
		return $result;
	}
	/**
	 * 根据version和file表id找到PG MO各个部门的信息
	 */
	public function substance($condition){
		$result = DB::table('file')
					->join("entry_row","file.id",'=','entry_row.file_id')
					->where("file.version","=",$condition['version'])
					->where("entry_row.parent_id",'=','')
					->where("entry_row.virtual_row",'<>',0)
					->groupby("org_unit")
					->select('file.version','entry_row.*')
					->get();
		return $result;
	}
	
	public function tableimage($condition){
		$result = DB::table('file')
					->join("entry_row",'file.id','=','entry_row.file_id')
					->where('entry_row.parent_id','=','0')
					->where('file.version','=',$condition['version'])
					->select('entry_row.id')
					->get();
		return $result;
	}
	public function delete(){
		$result = DB::table('file')->truncate();
		return $result;
	}
}