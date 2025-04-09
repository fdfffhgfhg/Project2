<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class admin extends controller
{   
    public $AdminModel;
    public $MyController;
    var $template = 'admin';
    var $title = 'Tai khoan';
    public $session = 'session';
    public $message = [];
    function __construct()
    {
        $this->AdminModel = $this->model('AdminModel');
        $this->MyController = new MyController();
    }
    public function index(){
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->AdminModel->select_array("*");
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
        $data_admin = $this->MyController->getIndexAdmin();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data_post = $_POST['data_post'];
            $password = password_hash($data_post['password'],PASSWORD_BCRYPT);
            $data_post['password'] = $password;
            $data_post['publish'] ? $publish = 1 : $publish = 0;
            $data_post['publish'] = $publish;
            $result = $this->AdminModel->add($data_post);
            $return = json_decode($result,true);
            if($return['type'] == "successfully"){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('flash','Them thanh cong danh muc san pham');
            }
        }

        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/add',
            'title' => "Thêm mới ".$this->title,
            'template' => $this->template,
          ];
        $this->view('masterlayout',$data);

    }
    function edit($id){
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->AdminModel->select_row("*",['id' => $id]);
        
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $data_post = $_POST['data_post'];
            $data_post['publish'] ? $publish = 1 : $publish = 0;
            $data_post['publish'] = $publish;
            $result = $this->AdminModel->update($data_post,['id' => $id]);
            $return = json_decode($result,true);
            if($return['type'] == "successfully"){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('flash','Cập nhật thành công danh mục sản phẩm');
            }
        }

        $data = [
            'data_admin' => $data_admin,
            'page' => $this->template.'/edit',
            'title' => "Cập nhật ".$this->title,
            'template' => $this->template,
            'datas' => $datas,
          ];
        $this->view('masterlayout',$data);
    }
    function delete(){
        $id = $_POST['id'];
        $result = $this->AdminModel->delete(['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){
            echo json_encode(
               [
                'result' => "true",
                'message' => $return['message']
               ]
            );

        }
    }
    function delAll(){
        $listID = $_POST['listID'];
        $arrayID = explode(',',$listID);
        foreach($arrayID as $key => $value){
            $this->AdminModel->delete(['id' => $value]);
        }
        echo json_encode(
           [
             'result' => 'success',
             'message' => 'Delete successfully'
           ]
        );
    }
    function checkpublish(){
        $id = $_POST['id'];
        $value = $_POST['value'];
        $fields = $_POST['fields'];
        $dataUpdate[$fields] = $value;
        $result = $this->AdminModel->update($dataUpdate,['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){

        }
    }
    function demo(){
        
    }
}