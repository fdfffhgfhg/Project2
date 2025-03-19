<?php
class category extends controller
{   
    public $CategoryModel;
    var $template = 'category';
    var $title = 'Danh mục sản phẩm';
    function __construct()
    {
        $this->CategoryModel = $this->model('CategoryModel');
    }
    public function index(){
        /*$kq = $this->CategoryModel->select_array();
        echo "<pre>";
        print_r($kq); die;*/
        $data = [
            'page' => $this->template.'/index',
            'title' => "Thêm mới ".$this->title,
          ];
        $this->view('masterlayout',$data);
    }
    public function add(){
         

    }
    function demo(){
        
    }
}