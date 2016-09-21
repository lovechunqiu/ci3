<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 数据库管理
 * @author: lideqiang87@gmail.com
 * @version: 1.0.0
 * @since: 2016-09-21
 */
class Db extends MY_Controller {

	//默认每个备份大小以k为单位
	private $b_filesize  = 1024;
	//默认每组备份还原等待时间以秒为单位
	private $waitbaktime = 0;

	function __construct(){
        parent::__construct();
    }

    /**
     * 列表页面
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
	public function index(){

		$res = $this->db->query("SHOW TABLE STATUS");
		//返回数组，数组中是一个一个的对象
		$res->result();
		//数据库内所有表信息
        $all_table_info    = $res->result_array(); 
        $data['tablelist'] = $all_table_info;

        $this->_return('db/index', $data);

	}

	/**
     * 查看表结构
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
	public function showtable(){
		$config = $this->_DBReback();
		$get    = $this->input->get(NULL, TRUE);
		$table  = str_replace(";","",$get['tables']);
        
        $this->load->library('dbreback', $config);
        $content = $this->dbreback->tableColumns($table);
		$data['tablecontent'] = $content;
		$this->_return('db/showtable', $data);

	}

	/**
     * 备份参数
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     */
    public function set(){
    	$post = $this->input->post('tables', TRUE);
    	$data['tables'] = $post;
        $this->_return('db/set', $data);
    }

    /**
     * 备份数据库
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    public function backup(){

    	$post = $this->data;
    	
        $savepath=$post['savepath'] ? $post['savepath'] : date("YmdHis",time());
        $savepath = RUNTIME_PATH . 'bdata/' . $savepath . "/";
        $config = $this->_DBReback($savepath);
        $this->load->library('dbreback', $config);

        $this->dbreback->setFileSize($this->b_filesize);
        
        if($post['baktable']){
            $b_table = explode(",", $post['baktable']);//要备份的表checkbox$_POST['checkbox'];
        }
        $this->dbreback->backup($b_table);
        $this->_writeInfo($post['info'], $savepath.'/');
        	
        $this->callback_json('success');
    }

    /**
     * 备份列表数据
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @return [type]     [description]
     */
    public function baklist()
    {
		$list=array();
		$db_dir = RUNTIME_PATH . 'bdata/';
		if(!empty($db_dir) && $od=opendir($db_dir)){
			//读取目录的内容		
			while(($file=readdir($od))!==false){
				if($file!="." && $file!=".." && is_dir($db_dir."/".$file)){
					$row=array();
					$row['dirname'] = $file;
					//备份文件夹内部文件
					if($od2=opendir($db_dir."/".$file) ){
						$row['baksize'] = 0;
						//读取目录内文件
						while(($file2=readdir($od2))!==false){
							preg_match('|\.(\w+)$|i',$file2, $ext);
							$extend = isset($ext[1]) ? strtolower($ext[1]) : '';//文件后缀
							
							if($file2!="." && $file2!=".." && !is_dir($db_dir."/" . $file."/".$file2)){
								if($extend=="txt"){
									$row['baktime'] = date("Y-m-d H:i:s",filemtime("$db_dir/$file/$file2"));
									$row['bakdetail'] = ReadFiletext("$db_dir/$file/$file2");
								}
								$row['baksize'] += filesize($db_dir . "/" . $file . "/" . $file2);
							}
						}
					}
					//备份文件夹内部文件
					$list[]=$row;
				}
			}
		}

		$data['baklist'] = $list;
		$this->_return('db/baklist', $data);

    }

	/**
     * 配置信息
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  string     $savePath [description]
     * @return [type]               [description]
     */
	private function _DBReback($savePath='')
    {
        $data_dir = $savePath;
        $config = array(
            'host'            => $this->db->hostname,
            'port'            => '3306',
            'userName'        => $this->db->username,
            'userPassword'    => $this->db->password,
            'dbprefix'        => $this->db->dbprefix,
            'dbname'          => $this->db->database,
            'charset'        => 'UTF8',
            'path'            => $data_dir,
        );
        return $config;
        
    }

    /**
     * 写入文件
     * @author lideqiang87@gmail.com
     * @date   2016-09-21
     * @param  [type]     $info [description]
     * @param  [type]     $path [description]
     * @return [type]           [description]
     */
    private function _writeInfo($info, $path)
    {
        if(is_dir($path)){
            $filename = $path."info.txt";
            $info = !empty($info)?$info:'无';
            if(!file_put_contents($filename, $info)){
                $this->error("说明信息写入失败！");
            }
        }
    }

}

/* End of file db.php */
/* Location: ./admin/controllers/db.php */
