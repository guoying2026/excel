<?php

class Content extends Controller
{
	/**
     * 展示首页
     * @return void
     */
	public function index(){
		$EntryRowModel = $this->viewModels('EntryRowModel');
		$result = $EntryRowModel->entry_row();
		
		$this->arr['result'] = $result;
		$this->view('content/index',$this->arr);
	}
	/**
     * 在entry表中查取信息
     * @return void
     */
	public function entry(){
		$condition = $_POST;
		$EntryModel = $this->viewModels('EntryModel');
		$result = $EntryModel->entry($condition);
		echo json_encode($result);
	}
	public function substance(){
		$condition = $_POST;
		$FileModel = $this->viewModels('FileModel');
		$EntryModel = $this->viewModels('EntryModel');
		//根据version查找季度有事的部门
		$this->arr['filesub'] = $FileModel->substance($condition);
		//根entry_row表id查找entry信息
		$this->arr['entrysub'] = $EntryModel->substance($condition);
		var_dump($this->arr);
		$this->view('content/substance',$this->arr);
	}

}