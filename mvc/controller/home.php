<?php
class home extends controller
{   
    public $Mymodel;
    public $table = 'tbl_category';
    function __construct()
    {
        $this->Mymodel = $this->model('mymodel');
    }
    public function index(){
        $where = [
            'name_cate' => 'Phone' ,
             'code_cate' => 'IP_2024_12',
            ];
        $kq = $this->Mymodel->select_array($this->table,'*',$where);
        $this->view('masterlayout',[
            'page' => 'user/index',
            'array' => $kq,
        ]);
    }
    public function add(){
         

    }
    function demo(){
        
    }
}