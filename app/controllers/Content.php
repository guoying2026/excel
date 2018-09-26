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
		$param = func_get_args();
		$condition['version'] = $param[0]['version'];
		$condition['id'] = $param[1]['id'];
		$FileModel = $this->viewModels('FileModel');
		$EntryModel = $this->viewModels('EntryModel');
		$EntryRowModel = $this->viewModels('EntryRowModel');
		//根据version查找季度有事的部门
		$this->arr['filesub'] = $FileModel->substance($condition);
		//根entry_row表id查找entry信息
		$this->arr['entrysub'] = $EntryModel->substance($condition);
		$this->arr['condition'] = $condition;
		//计算有多少相关部门
		$this->arr['countdeparentment'] = count($this->arr['filesub'])+10;
		$arrnumber = [];
		$i = 0;
		$temp = '';
		foreach($this->arr['entrysub'] as $name){
			if($temp != $name->ref_number){
				$arrnumber[$i] = $name->ref_number;
				$temp = $arrnumber[$i];
				$i++;
			}
		}
		array_shift($arrnumber);
		$this->arr['all'] = $EntryRowModel->substance($arrnumber);
		$this->view('content/substance',$this->arr);
	}

}