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
			'field_row' => $condition['field_row'],
			'field_num' => $condition['field_num'],
			'measures_column' => $condition['measures_column'],
			'value_row_start' => $condition['value_row_start']
		]);
		return $result;
	}
	/**
	 * 查询file表的version
     */
	public function version(){
		$result = DB::table('file')
					->select('version','id')
					->get();
		return $result;
	}
}