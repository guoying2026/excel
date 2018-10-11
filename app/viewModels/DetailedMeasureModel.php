<?php
use Illuminate\Database\Capsule\Manager as DB;
class DetailedMeasureModel extends Controller
{
	/**
	 * 插入detailed_measure表
     */
	public function create_dm($condition){
		$result = $this->model('DetailedMeasure')::updateOrCreate([
			'e_r_id' => $condition['e_r_id'],
			'dm_no' => $condition['dm_no']
		],[
			'dm_owner' => $condition['dm_owner'],
			'compl_in' => $condition['compl_in'],
			'impl_date' => $condition['impl_date'],
			'intented_effect' => $condition['intented_effect']
		]);
		return $result;
	}
	public function delete(){
		$result = DB::table('detailed_measure')->truncate();
		return $result;
	}
}