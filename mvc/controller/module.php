<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/controller/MyController.php";
class module extends controller
{   
    public $ModuleModel;
    public $MyController;
    var $template = 'module';
    var $title = 'Module';
    public $session = 'session';
    
    function __construct()
    {
        $this->ModuleModel = $this->model('ModuleModel');
        $this->MyController = new MyController();
    }
    public function index(){
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->ModuleModel->select_array("*" , ['parentID' => 0]);
        foreach($datas as $key => $val){
            $children = $this->ModuleModel->select_array("*",['parentID' => $val['id']]);
            $datas[$key]['children'] = $children;
        }
        $data = [
            'data_admin'      => $data_admin,
            'page'            => $this->template.'/index',
            'title'           => "Danh sách ".$this->title,
            'template'        => $this->template,
            'datas'           => $datas,
          ];
        $this->view('masterlayout',$data);
    }
    public function add(){
        $data_admin = $this->MyController->getIndexAdmin();
        $sort_max = $this->ModuleModel->select_max_fields('sort',NULL);
        if(isset($_POST['submit'])){
            $data_post = $_POST['data_post'];
            $data_post['publish'] ? $publish = 1 : $publish = 0;
            $data_post['publish'] = $publish;
            $data_post['name'] = trim($data_post['name']);
            $data_post['controller'] = trim($data_post['controller']);
            $data_post['icon'] = trim($data_post['icon']);
            $data_post['link'] = trim($data_post['link']);
            $data_post['sort'] = $sort_max['sort'] + 1;

            $data_post['created_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
            $result = $this->ModuleModel->add($data_post);
            $return = json_decode($result,true);
            if($return['type'] == "successfully"){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('flash','Them thanh cong danh muc san pham');
            }
        }
        // parent ID
        $parent = $this->ModuleModel->select_array("*",['parentID' => 0]);

        $data = [
            'data_admin'      => $data_admin,
            'page' => $this->template.'/add',
            'title' => "Thêm mới ".$this->title,
            'template' => $this->template,
            'parent' => $parent,
          ];
        $this->view('masterlayout',$data);

    }
    function edit($id){
        $data_admin = $this->MyController->getIndexAdmin();
        $datas = $this->ModuleModel->select_row("*",['id' => $id]);
        
        if(isset($_POST['submit'])){
            $data_post = $_POST['data_post'];
            if($id == $data_post['parentID']){
                $redirect = new redirect($this->template.'/'.'index');
                $redirect->setFlash('error','Trung voi danh muc cha');
            }
            else{
                $data_post['name'] = trim($data_post['name']);
                $data_post['controller'] = trim($data_post['controller']);
                $data_post['icon'] = trim($data_post['icon']);
                $data_post['link'] = trim($data_post['link']);
                $data_post['publish'] ? $publish = 1 : $publish = 0;
                $data_post['publish'] = $publish;
                $data_post['updated_at'] = gmdate('Y-m-d H:i:s', time() + 7*3600);
                $result = $this->ModuleModel->update($data_post,['id' => $id]);
                $return = json_decode($result,true);
                if($return['type'] == "successfully"){
                    $redirect = new redirect($this->template.'/'.'index');
                    $redirect->setFlash('flash','Cập nhật thành công module');
                }
            }
        }

        $parent = $this->ModuleModel->select_array("*",['parentID' => 0]);
        $data = [
            'data_admin'      => $data_admin,
            'page' => $this->template.'/edit',
            'title' => "Cập nhật ".$this->title,
            'template' => $this->template,
            'parent' => $parent,
            'datas' => $datas,
          ];
        $this->view('masterlayout',$data);
    }
    function delete(){
        $id = $_POST['id'];
        $result = $this->ModuleModel->delete(['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){
            $this->ModuleModel->update(['parentID = 0'],['parentID' => $id]);
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
            $this->ModuleModel->delete(['id' => $value]);
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
        $result = $this->ModuleModel->update($dataUpdate,['id' => $id]);
        $return = json_decode($result,true);
        if($return['type'] == "successfully"){

        }
    }
    function demo(){
        
    }
}