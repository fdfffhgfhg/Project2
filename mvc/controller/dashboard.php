<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class auth extends controller{
     // load Model
     public $CategoryModel;
     // load Mycontroller
     public $MyController;
     // load helper
     public $JWTOKEN;
     public $Auth;
    public $AdminModel;
    var $template = 'dashboard';

    function __construct()
    {
        $this->AdminModel = $this->model('AdminModel');
        $this->MyController = new MyController();
        // load helper
        $this->JWTOKEN = $this->helper('JWTOKEN');
        $this->Auth = $this->helper('Auth');
    }
    function index(){
         // decode token
         if(isset($_SESSION['admin'])){
            $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'],KEYS);
            if($verify != NULL && $verify != 0){
                $auth = $this->Auth->checkAuth($verify);
                if($auth != true){
                    $redirect = new redirect('auth/index');
                }
            }
            else{
                $redirect = new redirect('auth/index');
            }
        }
        else{
            $redirect = new redirect('auth/index');
        }
        $data_admin = $this->MyController->getIndexAdmin();
        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/index',
            'template' => $this->template,
          ];
        $this->view('masterlayout',$data);
    }
}