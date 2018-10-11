<?php

class Content extends Controller
{
	/**
     * 展示首页
     * @return void
     */
	public function index(){
		$FileModel = $this->viewModels('FileModel');
		$result = $FileModel->file_version();
		
		$this->arr['result'] = $result;
		$this->view('content/index',$this->arr);
	}
	public function entry_row(){
		$condition = $_POST;
		$EntryRowModel = $this->viewModels('EntryRowModel');
		$result['entryrow'] = $EntryRowModel->entry_row($condition);
		$result['levelimage'] = $EntryRowModel->levelimage($condition);
		$result['categoryname'] = $EntryRowModel->categoryname($condition);
		
		echo json_encode($result);
	}
	public function report(){
		$FileModel = $this->viewModels('FileModel');
		$EntryModel = $this->viewModels('EntryModel');
		$EntryRowModel = $this->viewModels('EntryRowModel');
		$LcchnProposalModel = $this->viewModels('LcchnProposalModel');
		$result1 = $FileModel->new_version();
		$con = [];
		foreach ($result1 as $file) {
			//$con数组里的id是文件id
			$con['id'] = $file->id;
			$con['version'] = $file->version;
		}
		if(count($con) < 1){
			$this->arr['tableimage'] = 'no';
			$this->view('content/report',$this->arr);
			exit;
		}
		// $k = 0;
		//应该循环多少张图表,根据最新季度找到多个e_r_id也是entry_row的主键id
		$this->arr['tableimage'] = $FileModel->tableimage($con);
		foreach($this->arr['tableimage'] as $name){
			$condition['id'] = $name->id;
			$condition['version'] = $con['version'];
			$this->arr['condition'][$name->id] = $condition;

			// //根据version查找季度有事的部门
			$this->arr['filesub'][$name->id] = $FileModel->substance($condition);
			$this->arr['lccpro'][$name->id] = $LcchnProposalModel->substance($condition);

			$this->arr['entrysub'][$name->id] = $EntryModel->substance($condition);
			// $k++;
		}
		$this->view('content/report',$this->arr);
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
		$LcchnProposalModel = $this->viewModels('LcchnProposalModel');

		//根据version查找季度有事的部门
		$this->arr['filesub'] = $FileModel->substance($condition);
		// var_dump($this->arr['filesub']);
		//根entry_row表id查找entry信息
		$this->arr['entrysub'] = $EntryModel->substance($condition);
		// var_dump($this->arr['entrysub']);
		$this->arr['lccpro'] = $LcchnProposalModel->substance($condition);

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
		$this->arr['entryd_ae'] = $EntryRowModel->entryd_ae($arrnumber);
		$result = $EntryRowModel->entry_rows();
		$this->arr['result'] = $result;
		$this->view('content/substance',$this->arr);
	}
	public function update_comment(){
		$condition = $_POST;
		$LcchnProposalModel = $this->viewModels('LcchnProposalModel');
		$result = $LcchnProposalModel->update_comment($condition);
		echo json_encode($result);
	}
	public function update_level(){
		$condition = $_POST;
		$EntryModel = $this->viewModels('EntryModel');
		$EntryModel->update_level($condition);
		$LcchnProposalModel = $this->viewModels('LcchnProposalModel');
		$result = $LcchnProposalModel->update_level($condition);
		echo json_encode($result);
	}
	public function update_minutes(){
		$condition = $_POST;
		$LcchnProposalModel = $this->viewModels('LcchnProposalModel');
		$result = $LcchnProposalModel->update_minutes($condition);
		echo json_encode($result);
	}
}