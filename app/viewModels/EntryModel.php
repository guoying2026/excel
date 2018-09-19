<?php

class EntryModel extends Controller
{
	/**
	 * 向entry表中批量存取表格基本信息
     */
	public function create_entry($condition){
		$result = $this->model('Entry')::create($condition);
		return $result;
	}
}