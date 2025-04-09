<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class auth extends controller{
    // load Models
    public $AdminModel;
    // load Mycontroller
    public $MyController;
    // load helper
    public $JWTOKEN;
    const DASHBOARD = 'dashboard';
    const ACTION = 'index';
    const CONTROLLER = 'auth';
    function __construct()
    {
        $this->AdminModel = $this->model('AdminModel');
        $this->MyController = new MyController();
        // load helper
        $this->JWTOKEN = $this->helper('JWTOKEN');
    }
    function index(){
        $datas = [];
        if(isset($_COOKIE['remember'])){
            $datas = json_decode($_COOKIE['remember'],true);

        }
        $data = [
            'datas' => $datas,
        ];
        $this->view('login',[]);
    }
    function login(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Tim trong CSDL co ton tai user khong
            $check = $this->AdminModel->select_row("*",['username' => $username]);
            if(isset($check) && $check != null){
               if(password_verify($password,$check['password'])){
                  if(isset($_POST['remember']) && $_POST['remember'] == 1){
                      $array_remember = [
                          'username' => $username,
                          'password' => $password,
                          'remember' => 1
                      ];
                      $json = json_encode($array_remember);
                      setcookie('remember',$json,time() + 86400,'/');
                  }
                  else{
                    setcookie('remember','',0,'/');
                  }
                $array = [
                    'time' => time() + 3600*24,
                    'key' => KEYS,
                    'info' => [
                         'id' => $check['id']
                    ],
                ];
                $jwt = $this->JWTOKEN->CreateToken($array);
                $_SESSION['admin'] = $jwt;
                $redirect = new redirect(self::DASHBOARD.'/'.self::ACTION);
               }
               else{
                $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
                $redirect->setFlash('errors','Sai mat khau');
               }
            }
            else{
               $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
               $redirect->setFlash('errors','Tai khoan khong ton tai');
            }
        }
    }
    function logout(){
        if(isset($_SESSION['admin']) && $_SESSION['admin']['logged'] == true){
            unset($_SESSION['admin']);
            $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
        }
        else{
            $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
        }
    }
}