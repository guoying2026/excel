<?php
use Illuminate\Database\Capsule\Manager as DB;

class LcchnProposalModel extends Controller
{
	public function create_lcchn_proposal($e_r_id){
		$result = $this->model('LcchnProposal')::firstOrCreate(['e_r_id'=>$e_r_id]);
		return $result;
	}
	public function substance($condition){
		$result = DB::table('lcchn_proposal')
					->where("e_r_id",'=',$condition['id'])
					->get();
		return $result;
	}
	public function update_comment($condition){
		$result = DB::table('lcchn_proposal')->where('e_r_id',$condition['e_r_id'])->update(['comment'=>$condition['comment']]);
		return $result;
	}
	public function update_level($condition){
		$result = DB::table('lcchn_proposal')->where('e_r_id',$condition['id'])->update(['level'=>$condition['level']]);
		return $result;
	}
	public function update_minutes($condition){
		$result = DB::table('lcchn_proposal')->where('e_r_id',$condition['e_r_id'])->update(['minutes'=>$condition['minutes']]);
		return $result;
	}
	public function delete(){
		$result = DB::table('lcchn_proposal')->truncate();
		return $result;
	}
}