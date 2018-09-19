<?php

class DetailedMeasureModel extends Controller
{
	/**
	 * 插入detailed_measure表
     */
	public function create_dm($condition){
		$result = $this->model('DetailedMeasure')::create($condition);
		return $result;
	}
}