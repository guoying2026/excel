<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
/**
 * The default home controller, called when no controller/method has been passed
 * to the application.
 */
class Home extends Controller
{
    /**
     * 展示首页
     * @return void
     */
    public function index()
    {
        $this->view('home/index',$this->arr);
    }
    /**
     * 读取目录或文件
     * glob函数返回匹配指定模式的文件名和目录，返回包含匹配文件、目录数组。出错返回false
     * array_map 为数组的每个元素应用回调函数
     * @return json字符串[文件数组]
     */
    public function get_directory_file()
    {
        $result = array_map(function($n){
            return explode(SITE_PATH .'\\' .$_POST['path'] . '/', $n)[1];
        },glob(SITE_PATH .'\\' .$_POST['path'] . '/' . '*.*'));
        echo json_encode($result); 
    }
    /**
     * 将excle文件中的表格内容存到数据表
     * @return json字符串[文件数组]
     */
    public function upload()
    {
        $FileModel = $this->viewModels('FileModel');

        $condition = $_POST;
        $data1['filepath'] = DOC_ROOT_1.'//'.$condition['ag'];
        $data1['version'] = $condition['version'];
        $data1['field_row'] = 7;
        $data1['field_num'] = 41;
        $data1['measures_column'] = '';
        $data1['value_row_start'] = 8;

        //将文件基本信息存入到file表中
        $file1 = $FileModel->c_or_u_file($data1);
        //获取文件中所有的内容
        $result1 = $this->halldeFile($data1['filepath']);
        //将文件中的数据存到对应表中
        $this->save_table_file1($result1,$data1,$file1);
        
        $data2['filepath'] = DOC_ROOT_1.'//'.$condition['bu'];
        $data2['version'] = $condition['version'];
        $data2['field_row'] = 13;
        $data2['field_num'] = 49;
        $data2['measures_column'] = 50;
        $data2['value_row_start'] = 14;

        //将文件基本信息存入到file表中
        $file2 = $FileModel->c_or_u_file($data2);
        //获取文件中所有的内容
        $result2 = $this->halldeFile($data2['filepath']);
        //将文件中的数据存到对应表中
        $this->save_table_file2($result2,$data2,$file2);
    }
    /**
     * 调用工厂模式 获得所读文件的所有内容
     * @return [文件数组]
     */
    public function halldeFile($file){
        //判断文件类型
        $filetype = IOFactory::identify($file);
        //创建该类型$filetype的读取类
        $objReader = IOFactory::createReader($filetype);
        //只读取数据，忽略里面所有格式,优化读取速度
        $objReader->setReadDataOnly(true);
        //读取文件,获取当前激活的工作表，并解析全部放入数组中
        $reader = $objReader->load($file);
        $result = $reader->getActiveSheet()->toArray(null,false,false,true);
        //为了防止内存泄漏，手动清理
        $reader->disconnectWorksheets();
        unset($reader);
        return $result;
    }
    public function save_table_file1($result1,$data1,$file1){
        $EntryRowModel = $this->viewModels('EntryRowModel');
        $EntryModel = $this->viewModels('EntryModel');
        $DetailedMeasureModel = $this->viewModels('DetailedMeasureModel');
        $DetailedModel = $this->viewModels('DetailedModel');
        $len = count($result1);
        $j = 0;
        $conparent = [];
        foreach($result1 as $k => $v){
            $value_type = ($k != $data1['field_row'])?400:300;
            if($k >= $data1['field_row'] && $k <= $len){ 
                $conditions['file_id'] = $file1['id'];
                $conditions['row'] = $k;
                $conditions['virtual_row'] = $j;
                $conditions['org_unit'] = $v['A'];
                $conditions['ref_number'] = $v['B'];
                switch ($v['A']) {
                    case 'Bottom Up Risks':
                        $conditions['parent_id'] = $conparent['id'];
                        $entryrow = $EntryRowModel->create_entry_row($conditions);
                        break;
                    case 'CHN':
                        $conditions['parent_id'] = 0;
                        $entryrow = $EntryRowModel->create_entry_row($conditions);
                        $conparent['id'] = $entryrow['id'];
                        break;
                    default:
                        $conditions['parent_id'] = '';
                        $entryrow = $EntryRowModel->create_entry_row($conditions);
                        break;
                }
                foreach($v as $key => $val){
                    $con['e_r_id'] = $entryrow['id'];
                    $con['column'] = $key;
                    $con['value'] = $val;
                    $con['value_type'] = $value_type;
                    $entry = $EntryModel->create_entry($con);
                }
                $j++;
            }
        }
        return 1;
    }
    public function save_table_file2($result2,$data2,$file2){
        $EntryRowModel = $this->viewModels('EntryRowModel');
        $EntryModel = $this->viewModels('EntryModel');
        $DetailedMeasureModel = $this->viewModels('DetailedMeasureModel');
        $DetailedModel = $this->viewModels('DetailedModel');
        $len = count($result2);
        $j = 0;
        foreach($result2 as $k => $v){
            $value_type = ($k != $data2['field_row'])?200:100;
            if($k >= $data2['field_row'] && $k <= $len){ 
                $conditions['file_id'] = $file2['id'];
                $conditions['row'] = $k;
                $conditions['virtual_row'] = $j;
                $conditions['parent_id'] = '';
                $conditions['org_unit'] = $v['A'];
                $conditions['ref_number'] = $v['B'];
                $entryrow = $EntryRowModel->create_entry_row($conditions);
                $i = 1;
                $flag = 0;
                $condm = [];
                $condetailed = [];
                foreach($v as $key => $val){
                    if($i <= $data2['field_num']){
                        $con['e_r_id'] = $entryrow['id'];
                        $con['column'] = $key;
                        $con['value'] = $val;
                        $con['value_type'] = $value_type;
                        $entry = $EntryModel->create_entry($con);
                    } else if($i >= $data2['measures_column'] && $k > $data2['field_row']) {
                        if(null == $val){
                            break;
                        }
                        $flag++;
                        switch ($flag) {
                            case 1:
                                $condm['dm_no'] = $val;
                                break;
                            case 2:
                                $condetailed['detailed_measure'] = $val;
                                break;
                            case 3:
                                $condetailed['status_comment'] = $val;
                                break;
                            case 4:
                                $condm['dm_owner'] = $val;
                                break;
                            case 5:
                                $condm['compl_in'] = $val;
                                break;
                            case 6:
                                $condm['impl_date'] = $val;
                                break;
                            case 7:
                                $condm['intented_effect'] = $val;
                                break;
                            
                        }
                        if($flag == 7){
                            $flag = 0;
                            if(preg_match("/^\d*$/",$condm['dm_no'])){
                                $condm['e_r_id'] = $entryrow['id'];
                                $ress = $DetailedMeasureModel->create_dm($condm);
                                //将分行符"\r\n"转义成HTML的换行符
                                $condetailed_mea = nl2br($condetailed['detailed_measure']);
                                $condetailed_sta = nl2br($condetailed['status_comment']);
                                $arrmea = explode('<br />',$condetailed_mea);
                                $arrsta = explode('<br />',$condetailed_sta);
                                $length = count($arrmea);
                                $arrcc = [];
                                for($m = 0;$m < $length;$m++){
                                    $arrcc['d_m_id'] = $ress['id'];
                                    $arrcc['detailed_measure'] = $arrmea[$m];
                                    $arrcc['status_comment'] = $arrsta[$m];
                                    $DetailedModel->create_detailed($arrcc);
                                }  
                            }
                        }
                    }
                    $i++;
                }
                $j++;
            }
        }
        return 1;
    }
}