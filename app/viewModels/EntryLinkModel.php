<?php
/**
 * The default home controller, called when no controller/method has been passed
 * to the application.
 */
class EntryLinkModel extends Controller{
	/**
	 * 根据entry_id条件
     * 查询entry_link的parent_entry_id字段
     */
	public function search_version($condition){
		$result = $this->model('EntryLink')::where('entry_id','=',$condition['entry_id'])->get('parent_entry_id');
		return $result;
	}
	/**
     * 向entry_link表插入parent_entry_id和entry_id字段
     */
	public function insert_pid_eid($condition){
		$result = $this->model('EntryLink')::create($condition);
		return $result;
	}
}