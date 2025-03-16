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
            'page' => "user/index",
            'array' => $kq
        ]);
    }
    public function add(){
        $array = array(
            'id' => 5,
            'name_cate' => 'Xiaomi 19',
            'code_cate' => 'XM_2025_Q1',
            'description' => 'Lo hang quy 1 Xiaomi nam 2025',
        );
        $kq = $this->Mymodel->add($this->table,$array);     
        echo "<pre>";
        $result = json_decode($kq,true);
        print_r($result); 

    }
    public function update(){
        $array = array(
            'name_cate' => 'Iphone 19',
            'code_cate' => 'IP_2025_Q1',
            'description' => 'Lo hang quy 1 IPhone nam 2025',
        );
        $where = [
            'id' => 5 ,
        ];
        $kq = $this->Mymodel->update($this->table,$array,$where);
        echo "<pre>";
        $result = json_decode($kq,true);
        print_r($result);
    }
    public function delete(){
        $where = [
            'id' => 2 ,
        ];
        /*$kq = $this->Mymodel->delete($this->table,$where);
        $result = json_decode($kq,true);
        print_r($result);*/
        $kq = $this->Mymodel->select_row($this->table,'id,name_cate',$where);
        echo "<pre>";
        print_r($kq);
    }
}