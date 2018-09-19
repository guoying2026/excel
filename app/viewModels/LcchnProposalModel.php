<?php

class LcchnProposalModel extends Controller
{
	/**
	 * 根据 version和ref_number条件
	 * 插入和更新LcchnProposal表
     */
	public function aoru_version_ref_number($condition){
		$result = $this->model('LcchnProposal')::updateOrCreate([
			'version'=>$condition['version'],
			'ref_number'=>$condition['ref_number']
		],[
			'level'=>$condition['level'],
			'comment'=>$condition['comment'],
			'minutes'=>$condition['minutes']
		]);
		return $result;
	}
	/**
	 * 根据 version和ref_number条件
	 * 查询LcchnProposal表的minutes字段
	 * 返回一行记录
     */
	public function get_minutes($condition){
		$result = $this->model('LcchnProposal')::where('version','=',$condition['version'])->where('ref_number','=',$condition['ref_number'])->first(['minutes']);
		return $result;
	}
	/**
	 * 根据 version和ref_number条件
	 * 查询LcchnProposal表的level和comment字段
	 * 返回一行记录
     */
	public function get_chn_evaluated($condition){
		$result = $this->model('LcchnProposal')::where('version','=',$condition['version'])->where('ref_number','=',$condition['ref_number'])->first(['level','comment']);
		return $result;
	}
	/**
	 * 根据 version和ref_number条件
	 * 查询LcchnProposal表的level和comment字段
	 * 返回一行记录
     */
}