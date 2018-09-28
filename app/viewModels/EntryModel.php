<?php
use Illuminate\Database\Capsule\Manager as DB;
class EntryModel extends Controller
{
	/**
	 * 向entry表中批量存取表格基本信息
     */
	public function create_entry($condition){
		$result = $this->model('Entry')::updateOrCreate([
			'e_r_id' => $condition['e_r_id'],
			'column' => $condition['column']
		],[
			'value' => $condition['value'],
			'value_type' => $condition['value_type'],
		]);
		return $result;
	}
	/**
	 * 向entry表中提取表格基本信息
	 */
	public function entry($condition){
		$result = DB::table('entry')
					->where("e_r_id","=",$condition['e_r_id'])
					->whereIn("column",['Q','AF','AE','A','B','F','G','AC','C'])
					->get();
		return $result;
	}
	/**
	 * 从entry表中提取详细信息
	 */
	public function substance($condition){
		$result = DB::table('entry')
					->join('entry_row','entry_row.id','=','entry.e_r_id')
					->where("entry_row.id",'=',$condition['id'])
					->orwhere('entry_row.parent_id','=',$condition['id'])
					->whereIn('entry.value_type',['200','400'])
					->whereIn('entry.column',['B','C','D','M','Q','AA','AB','AC','AE','AF'])
					->select('entry_row.*','entry.column','entry.value','entry.value_type')
					->get();
		return $result;
	}
	public function update_level($condition){
		$result = $this->model('entry')::where('e_r_id',$condition['id'])->where('column','Q')->update(['value'=>$condition['level']]);
		return $result;
	}
}
