<?php
class controller{
    function view($view,$data = []){
        require_once "./mvc/view/cpanel/".$view.".php";
    }
    function model($models){
        require_once "./mvc/model/".$models.".php";
        return new $models;
    }
}