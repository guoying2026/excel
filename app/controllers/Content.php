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
}