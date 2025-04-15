<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class category extends controller
{   
    // load Model
    public $CategoryModel;
    // load Mycontroller
    public $MyController;
    // load helper
    public $JWTOKEN;
    public $Authorization;
    var $template = 'category';
    var $title = 'danh mục sản phẩm';
    public $session = 'session';
    const type = 1;
    
    function __construct()
    {
        $this->CategoryModel = $this->model('CategoryModel');
        $this->MyController = new MyController();
        // load helper
        $this->JWTOKEN = $this->helper('JWTOKEN');
        $this->Authorization = $this->helper('Authorization');
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
        $datas = $this->CategoryModel->select_array("*" , ['parentID' => 0]);
        foreach($datas as $key => $val){
            $children = $this->CategoryModel->select_array("*",['parentID' => $val['id']]);
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
        if(isset($_POST['submit'])){
            $data_admin = $this->MyController->getIndexAdmin();
            $data_post = $_POST['data_post'];
            $data_post['publish'] ? $publish = 1 : $publish = 0;
            $data_post['publish'] = $publish;
            $data_post['type'] = self::type;
            $data_post['created_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
            $result = $this->CategoryModel->add($data_post);
            $return = json_decode($result,true);
            if($return['type'] == "successfully"){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('flash','Them thanh cong danh muc san pham');
            }
        }
        // parent ID
        $parent = $this->CategoryModel->select_array("*",['parentID' => 0]);

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
        $datas = $this->CategoryModel->select_row("*",['id' => $id]);
        
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
                $result = $this->CategoryModel->update($data_post,['id' => $id]);
                $return = json_decode($result,true);
                if($return['type'] == "successfully"){
                    $redirect = new redirect($this->template.'/'.'index');
                    $redirect->setFlash('flash','Cập nhật thành công danh mục sản phẩm');
                }
            }
        }

        $parent = $this->CategoryModel->select_array("*",['parentID' => 0]);
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
        $result = $this->CategoryModel->delete(['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){
            $this->CategoryModel->update(['parentID = 0'],['parentID' => $id]);
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
            $this->CategoryModel->delete(['id' => $value]);
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
        $result = $this->CategoryModel->update($dataUpdate,['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){

        }
    }
    function demo(){
        
    }
}