<?php
class myModel extends Database
{
    protected $table;
    function select_array($data='*',$where = NULL){
        $sql = "SELECT $data FROM $this->table";
        if($where != NULL){
            $fields = array_keys($where);
            $fields_list = implode("",$fields);
            $values = array_values($where);
            $isFields = true;
            for($i = 0 ; $i < count($fields) ; $i++){
                if(!$isFields){
                    $sql .= " and ".$fields[$i]." = ?";
                }
                else{
                $isFields = false;
                $sql .= " where ".$fields[$i]." = ?";
                }
            }
            // echo $sql ;  
            $query = $this->conn->prepare($sql);
            $query->execute($values);
        }
        else{
            $query = $this->conn->prepare($sql);
            $query->execute();
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function add($data = NULL){
        $fields = array_keys($data);
        $fields_list = implode(",",$fields);
        $values = array_values($data);
        $qr = str_repeat("?,",count($fields)-1);
        $sql = "INSERT INTO ".$this->table."(".$fields_list.") VALUES (${qr}?)";
        echo $sql;
        $query = $this->conn->prepare($sql);
        if($query->execute($values)){
              return json_encode(
                array(
                    'type' => 'successfully',
                    'Message' => 'Insert data successfully',
                    'id' => $this->conn->lastInsertId(),
                )
                );
        }
        else{
            return json_encode(
                array(
                    'type' => 'fails',
                    'Message' => 'Insert data failed',
                )
                );
        }
    }
    function update($data = NULL,$where = NULL){
          if($data != NULL && $where != NULL){
            $fields = array_keys($data);
            $values = array_values($data);
            $where_array = array_keys($where);
            $where_value = array_values($where);
            $sql = "UPDATE $this->table SET ";
            $isFields = true;
            for($i = 0 ; $i < count($fields) ; $i++){
                if(!$isFields){
                    $sql .= " , ".$fields[$i]." = ?";
                }
                else{
                    $isFields = false;
                    $sql .= " ".$fields[$i]." = ?";
                }
            }
            $isFields = true;
            for($i = 0 ; $i < count($where_array) ; $i++){
                if(!$isFields){
                    $sql .= " and ".$where_array[$i]." = ".$where_value[$i]."";
                }
                else{
                $isFields = false;
                $sql .= " where ".$where_array[$i]." = ".$where_value[$i]."";
                }
            }
            //echo $sql;
            $query = $this->conn->prepare($sql);
            if($query->execute($values)){
                return json_encode(
                    array(
                        'type' => 'successfully',
                        'message' => 'Updated successfully',
                        'id' => $this->conn->lastInsertId(),
                    )
                    );
            }
            else{
                return json_encode(
                    array(
                        'type' => 'failed',
                        'message' => 'Updated failed',
                    )
                    );
            }
          }
    }
    function delete($where = NULL){
         $sql = "DELETE from $this->table";
         if($where != NULL){
            $where_array = array_keys($where);
            $where_value = array_values($where);
            $isFields = true;
            $stringwhere = 'where';
            for($i = 0 ; $i < count($where_array) ; $i++){
                if(!$isFields){
                    $sql .= " and ";
                    $stringwhere = '';
                }
                $isFields = false;
                $sql .= " ".$stringwhere." ".$where_array[$i]."  = ".$where_value[$i]."  " ; 
            }
         }
         $query = $this->conn->prepare($sql);
         if($query->execute()){
            return json_encode(
                     array(
                       'type' => 'successfully',
                       'message' => 'Deleted successfully',
                       'id' => $this->conn->lastInsertId(),
                    )
             );
        }else{
            return json_encode(
               array(
                  'type' => 'failed',
                  'message' => 'Delete failed',
                   )
               );
        }

    }
    function select_row($data="*",$where=NULL){
        $sql = "SELECT $data FROM $this->table";
        if($where != NULL){
            $where_array = array_keys($where);
            $where_value = array_values($where);
            $isFields = true;
            $stringwhere = "where";
            for($i = 0 ; $i < count($where_array) ; $i++){
                if(!$isFields){
                    $sql .= " and ";
                    $stringwhere = '';
                }
                $isFields = false;
                $sql .= " ".$stringwhere." ".$where_array[$i]."  = ? " ; 
            }
            $query = $this->conn->prepare($sql);
            $query->execute($where_value);
            return $query->fetch(PDO::FETCH_ASSOC);

        }
    }
    function select_max_fields($data = '' , $where = NULL){
        if($data != NULL){
            $sql = "SELECT MAX(".$data.") FROM $this->table";
        }
        if($where != NULL){
            $where_array = array_keys($where);
            $where_value = array_values($where);
            $isFields_where = true;
            $stringWhere = "where";
            for($i = 0 ; $i < count($where_array) ; $i++){
                if(!$isFields_where){
                   $sql .= " and " ;
                   $stringWhere = '';
                }
                $isFields_where = false;
                $sql .= "" .$stringWhere." ".$where_array[$i]." = ?";
            } 
            $query = $this->conn->prepare($sql);
            $query->execute($where_value);
        }
        else{
            $query = $this->conn->prepare($sql);
            $query->execute();
        }
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}