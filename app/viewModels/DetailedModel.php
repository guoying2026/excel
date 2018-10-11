<?php
use Illuminate\Database\Capsule\Manager as DB;
class DetailedModel extends Controller
{
	/**
	 * 插入detailed_measure表
     */
	public function create_detailed($condition){
		$result = $this->model('Detailed')::updateOrCreate([
			'd_m_id' => $condition['d_m_id'],
			'detailed_measure' => $condition['detailed_measure'],
		],[
			'status_comment' => $condition['status_comment'],
		]);
		return $result;
	}
	public function delete(){
		$result = DB::table('detailed')->truncate();
		return $result;
	}
}