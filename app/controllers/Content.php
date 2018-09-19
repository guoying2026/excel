<?php

class Content extends Controller{
	public function index(){
		$FileModel = $this->viewModels('FileModel');
		$EntryRowModel = $this->viewModels('EntryRowModel');

		// $result = $FileModel->version();
		$condition = [1,2];
		$result = $EntryRowModel->entry_row($condition);
		var_dump($result);
		// foreach ($result as $res) {
		// 	var_dump($res->file_id);
		// 	var_dump($res->version);
		// 	var_dump($res->column);
		// 	var_dump($res->ref_number);
		// 	var_dump($res->value);
		// }
		// $this->view('content/index',$result);
	}
	public function truncate(){
		$this->view('home/index',$this);
	}
}