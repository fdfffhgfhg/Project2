<?php
class MyController extends controller{
    public $ModuleModels;
    function __construct(){
        $this->ModuleModels = $this->model('ModuleModel');
    }
    function getIndexAdmin(){
       $data['getModule'] = $this->getModule();
       return $data;
    }
    function getModule(){
        $datas = $this->ModuleModels->select_array("*" , ['parentID' => 0]);
        foreach($datas as $key => $val){
            $children = $this->ModuleModels->select_array("*",['parentID' => $val['id'] , 'publish' => 1]);
            $datas[$key]['children'] = $children;
        }
        return $datas;
    }
}