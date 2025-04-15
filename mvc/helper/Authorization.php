<?php

class Authorization extends controller{
    public $AdminModels;

    function __construct()
    {
        $this->AdminModels = $this->model('AdminModel');
    }
    function checkAuth($array){
        $id = $array['id'];
        $username = $array['username'];
        $checkUS = $this->AdminModels->select_array('*',['id' => $id , 'username' => $username]);
        if($checkUS != null && count($checkUS) > 0){
            return true;
        }
        else{
            return false;
        } 
    }
}