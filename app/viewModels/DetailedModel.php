<?php

class DetailedModel extends Controller
{
	/**
	 * 插入detailed_measure表
     */
	public function create_detailed($condition){
		$result = $this->model('Detailed')::create($condition);
		return $result;
	}
}