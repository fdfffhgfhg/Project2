<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class product extends controller
{   
    // load Model
    public $CategoryModel;
    public $ProductModel;
    // load Mycontroller
    public $MyController;
    // load helper
    public $JWTOKEN;
    public $uploads;
    public $Authorization;
    var $template = 'product';
    var $title = 'danh mục sản phẩm';
    public $message = [];
    // hinh anh
    var $path_dir = 'public/uploads/images/product/';
    function __construct()
    { 
        $this->CategoryModel = $this->model('CategoryModel');
        $this->ProductModel = $this->model('ProductModel');
        $this->MyController = new MyController();
        // load helper
        $this->JWTOKEN = $this->helper('JWTOKEN');
        $this->Authorization = $this->helper('Authorization');
        $this->uploads = $this->helper('uploads');
    }
    public function index(){
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
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->ProductModel->select_array("*" , NULL,'id desc' , NULL , NULL , ['']);
        foreach($datas as $key => $val){
            $children = $this->ProductModel->select_array("*",['parentID' => $val['id']]);
            $datas[$key]['children'] = $children;
        }
        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/index',
            'title' => "Danh sách ".$this->title,
            'template' => $this->template,
            'datas' => $datas,
          ];
        $this->view('masterlayout',$data);
    }
    public function add(){
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
        $data_admin = $this->MyController->getIndexAdmin();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if($_FILES['images']['name']){
                 $path_dir = $this->path_dir;
                 $data_upload = $this->uploads->upload($_FILES['image'],$path_dir,uniqid(),300,300);
                 if($data_upload['result'] == "false"){
                    $redirect = new redirect($this->template.'/'.'index');
                    $redirect->setFlash('flash',$data_upload['message']);
                 }
                 else{
                    $image = $data_upload['image'];
                    $thumb = $data_upload['thumb'];
                 }
            }
            else{
                $image = '';
                $thumb = '';
            }
            $data_post = $_POST['data_post'];
            $price = str_replace(',',"",$data_post['price']);
            $data_post['price'] = $price;
            $data_post['image'] = $image;
            $data_post['thumb'] = $thumb;
            $data_post['publish'] ? $publish = 1 : $publish = 0;
            $data_post['publish'] = $publish;
            $data_post['created_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
            $result = $this->ProductModel->add($data_post);
            $return = json_decode($result,true);
            if($return['type'] == "successfully"){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('flash','Them thanh cong danh muc san pham');
            }
        }
        // parent ID
        $parent = $this->ProductModel->select_array("*",['parentID' => 0]);
        foreach($parent as $key => $val){
            $parent[$key]['children'] = $this->ProductModel->select_array("*",['parentID' => $val['id']]);
        }

        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/add',
            'title' => "Thêm mới ".$this->title,
            'template' => $this->template,
            'parent' => $parent,
          ];
        $this->view('masterlayout',$data);

    }
    function edit($id){
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
        //=============================
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->ProductModel->select_row("*",['id' => $id]);
        
        if(isset($_POST['submit'])){
            $data_post = $_POST['data_post'];
            if($id == $data_post['parentID']){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('error','Trung voi danh muc cha');
            }
            else{
                $data_post['publish'] ? $publish = 1 : $publish = 0;
                $data_post['publish'] = $publish;
                $data_post['update_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
                $result = $this->ProductModel->update($data_post,['id' => $id]);
                $return = json_decode($result,true);
                if($return['type'] == "successfully"){
                    $redirect = new redirect($this->template.'/'.'index');
                    $redirect->setFlash('flash','Cập nhật thành công danh mục sản phẩm');
                }
            }
        }

        $parent = $this->ProductModel->select_array("*",['parentID' => 0]);
        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/edit',
            'title' => "Cập nhật ".$this->title,
            'template' => $this->template,
            'parent' => $parent,
            'datas' => $datas,
          ];
        $this->view('masterlayout',$data);
    }
    function delete(){
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
        //=============================
        $id = $_POST['id'];
        $result = $this->ProductModel->delete(['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){
            $this->ProductModel->update(['parentID = 0'],['parentID' => $id]);
            echo json_encode(
               [
                'result' => "true",
                'message' => $return['message']
               ]
            );

        }
    }
    function delAll(){
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
        //=============================
        $listID = $_POST['listID'];
        $arrayID = explode(',',$listID);
        foreach($arrayID as $key => $value){
            $this->ProductModel->delete(['id' => $value]);
        }
        echo json_encode(
           [
             'result' => 'success',
             'message' => 'Delete successfully'
           ]
        );
    }
    function checkpublish(){
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
        //=============================
        $id = $_POST['id'];
        $value = $_POST['value'];
        $fields = $_POST['fields'];
        $dataUpdate[$fields] = $value;
        $result = $this->ProductModel->update($dataUpdate,['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){

        }
    }
    function demo(){
        
    }
}