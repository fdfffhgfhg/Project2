<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class auth extends controller{
    public $AdminModel;
    public $MyController;
    var $template = 'dashboard';

    function __construct()
    {
        $this->AdminModel = $this->model('AdminModel');
        $this->MyController = new MyController();
    }
    function index(){
        $data_admin = $this->MyController->getIndexAdmin();
        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/index',
            'template' => $this->template,
          ];
        $this->view('masterlayout',$data);
    }
}