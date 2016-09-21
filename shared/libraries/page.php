<?php

/**
 * 后台分页
 * @author: lideqiang@cxshiguang.com
 * @version: 1.0.0
 * @since: 2015-10-26
 */
class Page {
    // 分页栏每页显示的页数
    public $rollPage = 8;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 5;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config = array('totalRow'=>'','totalPage'=>'','header'=>'','prev'=>'上一页','next'=>'下一页','first'=>'首页','last'=>'尾页','theme'=>'%totalRow% %totalPage% %header% %upPage% %linkPage%  %downPage% %end%');
    // 默认分页变量名
    protected $varPage;

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    
    public function __construct($options) {
        
        $this->totalRows = $options['totalRows'];
        $this->parameter = ! empty($options['parameter']) ? $options['parameter'] : '';
        $this->varPage   = ! empty($options['p']) ? $options['p'] : 'p';
        if(!empty($options['listRows'])) {
            $this->listRows = intval($options['listRows']);
        }else{
            $this->listRows = $this->pagesize;
        }
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->nowPage  = !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

    /**
     * 设置参数
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @param  [type]     $name  [description]
     * @param  [type]     $value [description]
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * 分页显示输出
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = $this->varPage;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        $idtagert = ! empty($parse['fragment']) ? "#" . $parse['fragment'] : "";
        if(isset($parse['query']) || isset($parse['fragment'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $querycount = count($params);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }else{
            $querycount = 0;
        }
        $pspan = ($querycount==0)?"":"&";
        $totalRows = "<li><a href='javascript:void(0);'>总记录数：".$this->totalRows."</a></li>";
        $totalPages = "<li><a href='javascript:void(0);'>" . $this->nowPage . " / ".$this->totalPages." 页</a></li>";
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<li><a href='".$url.$pspan.$p."=$upRow{$idtagert}'>".$this->config['prev']."</a></li>";
        }else{
            $upPage="<li><a href='javascript:void(0);'>".$this->config['prev']."</a></li>";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<li><a href='".$url.$pspan.$p."=$downRow{$idtagert}'>".$this->config['next']."</a></li>";
        }else{
            $downPage="<li><a href='javascript:void(0);'>".$this->config['next']."</a></li>";
        }
        // << < > >>
        if(false){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
            $prePage = "<li><a href='".$url.$pspan.$p."=$preRow{$idtagert}' >上".$this->rollPage."页</a>";
            $theFirst = "<li><a href='".$url.$pspan.$p."=1' >".$this->config['first']."</a></li>";
        }
        if(false){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "<li><a href='".$url.$pspan.$p."=$nextRow{$idtagert}' >下".$this->rollPage."页</a></li>";
            $theEnd = "<li><a href='".$url.$pspan.$p."=$theEndRow{$idtagert}' >".$this->config['last']."</a></li>";
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "<li><a href='".$url.$pspan.$p."=$page{$idtagert}'>".$page."</a></li>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "<li class='active'><a href='javascript:void(0);'>".$page."</a></li>";
                }
            }
        }
        
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            array($theFirst,$this->nowPage,$totalRows,$totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
        return '<ul>'.$pageStr.'</ul>';
    }

    /**
     * ajax分页
     * @author lideqiang@cxshiguang.com
     * @date   2015-10-26
     * @return [type]     [description]
     */
    public function ajax_show()
    {
        if(0 == $this->totalRows) return '';
        $p = $this->varPage;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        $idtagert = ($parse['fragment'])?"#".$parse['fragment']:"";
        if(isset($parse['query']) || isset($parse['fragment'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $querycount = count($params);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }else{
            $querycount = 0;
        }
        $pspan = ($querycount==0)?"":"&";
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a href='javascript:void(0);' onclick=\"ajax_show($upRow{$idtagert})\" >".$this->config['prev']."</a>";
        }else{
            $upPage="";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a javascript:void(0);' onclick=\"ajax_show($downRow{$idtagert})\"  style=\"display:none\">".$this->config['next']."</a>";
        }else{
            $downPage="";
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
           // $prePage = "<a href='javascript:void(0);' onclick=\"ajax_show($preRow{$idtagert})\"  >上".$this->rollPage."页</a>";
            $theFirst = "<a href='javascript:void(0);' onclick=\"ajax_show(1)\" >".$this->config['first']."</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "<a href='javascript:void(0);' onclick=\"ajax_show($nextRow{$idtagert})\"  >下".$this->rollPage."页</a>";
            $theEnd = "<a href='javascript:void(0);' onclick=\"ajax_show($theEndRow{$idtagert})\"  >".$this->config['last']."</a>";
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->totalPages;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "&nbsp;<a href='javascript:void(0);' onclick=\"ajax_show($page{$idtagert})\" >&nbsp;".$page."&nbsp;</a>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "&nbsp;<a  href='javascript:void(0);' onclick=\"ajax_show($page)\">&nbsp;".$page."&nbsp;</a>";
                }
            }
        }
        $theme = '共 %totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%';
        $pageStr     =     str_replace(
            array('%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%'),
            array($this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage),$theme);
        return $pageStr;
    }
    
}