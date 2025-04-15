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
    public $Authorization;
    const DASHBOARD = 'dashboard';
    const ACTION = 'index';
    const CONTROLLER = 'auth';
    function __construct()
    {
        $this->AdminModel = $this->model('AdminModel');
        $this->MyController = new MyController();
        // load helper
        $this->JWTOKEN = $this->helper('JWTOKEN');
        $this->Authorization = $this->helper('Authorization');
    }
    function index(){
        // decode token
        if(isset($_SESSION['admin'])){
            $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'],KEYS);
            if($verify != NULL && $verify != 0){
                $auth = $this->Authorization->checkAuth($verify);
                if($auth == true){
                    $redirect = new redirect(self::DASHBOARD.'/'.self::ACTION);
                }
            }
        }
        //=============================
        $datas = [];
        if(isset($_COOKIE['remember'])){
            $datas = json_decode($_COOKIE['remember'],true);

        }
        $data = [
            'datas' => $datas,
        ];
        $this->view('login',$data);
    }
    function login(){
        // decode token
        if(isset($_SESSION['admin'])){
            $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'],KEYS);
            if($verify != NULL && $verify != 0){
                $auth = $this->Authorization->checkAuth($verify);
                if($auth == true){
                    $redirect = new redirect(self::DASHBOARD.'/'.self::ACTION);
                }
            }
        }
        //=============================
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
                         'id' => $check['id'],
                         'username' => $check['username'],
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
         // decode token
         if(isset($_SESSION['admin'])){
            $verify = $this->JWTOKEN->decodeToken($_SESSION['admin'],KEYS);
            if($verify != NULL && $verify != 0){
                $auth = $this->Authorization->checkAuth($verify);
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
            unset($_SESSION['admin']);
            $redirect = new redirect(self::CONTROLLER.'/'.self::ACTION);
    }
}