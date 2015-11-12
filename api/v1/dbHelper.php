<?php
require_once 'config.php'; // Database setting constants [DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD]
class dbHelper {
    private $db;
    private $err;
    function __construct() {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
        try {
            $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            $response["status"] = "error";
            $response["message"] = 'Connection failed: ' . $e->getMessage();
            $response["data"] = null;
            //echoResponse(200, $response);
            exit;
        }
    }

//// BASIC FUNCTION /////////////////////////////

    function customQuery($customquery){
        try{
            
            $stmt = $this->db->prepare($customquery);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)<=0){
                $response["status"] = "warning";
                $response["message"] = "No data found.";
            }else{
                $response["status"] = "success";
                $response["message"] = "Data selected from database";
            }
                $response["data"] = $rows;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Select Failed: ' .$e->getMessage();
            $response["data"] = null;
        }
        return $response;
    }

    function select($table, $columns, $where, $order){
        try{
            $a = array();
            $w = "";
            foreach ($where as $key => $value) {
                $w .= " and " .$key. " like :".$key;
                $a[":".$key] = $value;
            }
            $stmt = $this->db->prepare("select ".$columns." from ".$table." where 1=1 ". $w." ".$order);
            $stmt->execute($a);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)<=0){
                $response["status"] = "warning";
                $response["message"] = "No data found in select of table ".$table;
            }else{
                $response["status"] = "success";
                $response["message"] = "Data selected from database";
            }
                $response["data"] = $rows;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Select Failed: ' .$e->getMessage();
            $response["data"] = null;
        }
        return $response;
    }   

    function insert($table, $columnsArray, $requiredColumnsArray) {
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);
        
        try{
            $a = array();
            $c = "";
            $v = "";
            foreach ($columnsArray as $key => $value) {
                if(!is_array($value)){
                    $c .= $key. ", ";
                    $v .= ":".$key. ", ";
                    $a[":".$key] = $value;
                }
            }
            $c = rtrim($c,', ');
            $v = rtrim($v,', ');
            $stmt =  $this->db->prepare("INSERT INTO $table($c) VALUES($v)");
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();
            $lastInsertId = $this->db->lastInsertId();
            $response["status"] = "success";
            $response["message"] = $affected_rows." row inserted into database";
            $response["data"] = $lastInsertId;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Insert Failed: ' .$e->getMessage();
            $response["data"] = 0;
        }
        return $response;
    }

    function update($table, $columnsArray, $where, $requiredColumnsArray){ 
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);
        try{
            $a = array();
            $w = "";
            $c = "";

            foreach ($where as $key => $value) {
                $w .= " and " .$key. " = :".$key;
                $a[":".$key] = $value;
            }
            foreach ($columnsArray as $key => $value) {
                if(!is_array($value)){
                    $c .= $key. " = :".$key.", ";
                    $a[":".$key] = $value;
                }
            }
                $c = rtrim($c,", ");

            $stmt =  $this->db->prepare("UPDATE $table SET $c WHERE 1=1 ".$w);
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();
            if($affected_rows<=0){
                $response["status"] = "warning";
                $response["message"] = "No row updated";
            }else{
                $response["status"] = "success";
                $response["message"] = $affected_rows." row(s) updated in database";
            }
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = "Update Failed: " .$e->getMessage();
        }
        return $response;
    }

    function delete($table, $where){
        if(count($where)<=0){
            $response["status"] = "warning";
            $response["message"] = "Delete Failed: At least one condition is required";
        }else{
            try{
                $a = array();
                $w = "";
                foreach ($where as $key => $value) {
                    $w .= " and " .$key. " = :".$key;
                    $a[":".$key] = $value;
                }
                $stmt =  $this->db->prepare("DELETE FROM $table WHERE 1=1 ".$w);
                $stmt->execute($a);
                $affected_rows = $stmt->rowCount();
                if($affected_rows<=0){
                    $response["status"] = "warning";
                    $response["message"] = "No row deleted";
                }else{
                    $response["status"] = "success";
                    $response["message"] = $affected_rows." row(s) deleted from database";
                }
            }catch(PDOException $e){
                $response["status"] = "error";
                $response["message"] = 'Delete Failed: ' .$e->getMessage();
            }
        }
        return $response;
    }

//// SPECIAL FUNCTION /////////////////////////////
    
    function insertwithTags($table, $columnsArray, $requiredColumnsArray) {
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);
        
        try{
            $a = array();
            $c = "";
            $v = "";
            $tags = array();
            foreach ($columnsArray as $key => $value) {
                if(!is_array($value)){
                    if($key != "tags"){
                        $c .= $key. ", "; //c = (name, surname, ID)
                        $v .= ":".$key. ", "; // v = (:name, :surname, :ID)
                        $a[":".$key] = $value; // a = array, a[:name] = Martin, a[:surname] = Novak, ...
                    }else{
                        $tags = explode(",", $value);
                    }
                }
            }
            $c = rtrim($c,', ');
            $v = rtrim($v,', ');

            $stmt =  $this->db->prepare("INSERT INTO $table($c) VALUES($v)");
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();
            $lastInsertId = $this->db->lastInsertId();             
            if($affected_rows<=0){
                $response["status"] = "warning";
                $response["message"] = "No row updated";
            }else{
                $response["status"] = "success";
                $response["message"] = $affected_rows." row(s) updated in database";
            }
           
            // ulozime tagy
            if($affected_rows > 0 && $lastInsertId > 0){

                $response = $this->insertTags($tags, $table, $lastInsertId);
            }

        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Insert Failed: ' .$e->getMessage();
            $response["data"] = 0;
        }
        return $response;
    }

    function updatewithTags($table, $columnsArray, $where, $requiredColumnsArray){ 
        $this->verifyRequiredParams($columnsArray, $requiredColumnsArray);
     
        try{
            $a = array();
            $w = "";
            $c = "";
            $tags = array();

            foreach ($where as $key => $value) {
                $w .= " and " .$key. " = :".$key;
                $a[":".$key] = $value;
            }            
            foreach ($columnsArray as $key => $value) {
                if(!is_array($value)){
                    if($key != "tags"){
                        $c .= $key. " = :".$key.", ";
                        $a[":".$key] = $value;
                    }else{
                        if(strlen($value) > 0){
                            $tags = explode(",", $value);
                        }                        
                    }
                }
            }

            $c = rtrim($c,", ");

            $stmt =  $this->db->prepare("UPDATE $table SET $c WHERE 1=1 ".$w);
            $stmt->execute($a);
            
            $affected_rows = $stmt->rowCount();
            if($affected_rows<=0){
                $response["status"] = "warning";
                $response["message"] = "No row updated";
            }else{
                $response["status"] = "success";
                $response["message"] = $affected_rows." row(s) updated in database";
            }
            // ulozime tagy
            $ID_element = $where['ID_'.$table];   
            if($ID_element > 0){
                
                // smazeme vsechny predchozi tagy
                $response = $this->deleteAllTagswithElementID($table, $ID_element); 
                if($response["status"] == "error"){
                    return $response;
                }                  
                
                $response = $this->insertTags($tags, $table, $ID_element);
            }

        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = "Update Failed: " .$e->getMessage();
        }
        return $response;
    }

    function insertTags($tags, $table, $lastInsertId){

        $finalResponse = null;       
        foreach ($tags as &$value) {
                    $tagCond = array("name" => $value);

                    $response2 = $this->select("tag", "*", $tagCond, "");
                    if($response2["status"] == "error"){
                        return $response2;
                    }
                    
                    if(count($response2["data"]) > 0){
                            // zjistime id tagu
                            foreach ($response2["data"] as &$value) {
                                $lastInsertedTagId = $value["ID_tag"];
                            }                        
                    }else{
                            // ulozime novy tag
                            $response3 = $this->insert("tag", $tagCond, array());
                            if($response3["status"]=="success"){
                                $lastInsertedTagId = $response3["data"]; 
                            }else{
                                return $response3;
                            }                      
                    }                    
                    // vazebni tabulka
                    if($lastInsertedTagId > 0 && $lastInsertId > 0){
                        $tabletag = $table."_tag";
                        $tagCond2 = array(
                            "ID_tag" => $lastInsertedTagId, 
                            "ID_link" => $lastInsertId
                        );
                        $finalResponse = $this->insert($tabletag, $tagCond2, array());
                    }else{
                        $finalResponse["status"] = "error";
                        $finalResponse["message"] = 'LastInsertedTagId or lastInsertId are not greater then 0 ';
                        $finalResponse["data"] = 0;
                    }                    
        }
        return $finalResponse;
    }

    function deleteAllTagswithElementID($table, $ID_element){

        $columnName = "ID_".$table;  
        $tableName = $table."_tag";        
        $whereCond = array($columnName => $ID_element);

        $response = $this->delete($tableName, $whereCond);
        return $response;
    }


    
    /*function selectP($name){
        // Select statement
        try{
            // $a = array();
            // $w = "";
            // // $where = array('name' => 'Ipsita Sahoo', 'uid'=>'170' );
            // foreach ($where as $key => $value) {
            //     $w .= " and " .$key. " like :".$key;
            //     $a[":".$key] = $value;
            // }
            // $stmt = $this->db->prepare("CALL `simpleproc`(@a);SELECT @a AS `param1`;");
            // $stmt->execute($a);
            // return $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $this->db->prepare("CALL $name(@resultId)"); 
            $stmt->execute(); 
            $stmt = $this->db->prepare("select @resultId as Id"); 
            $stmt->execute(); 
            $myResultId = $stmt->fetchColumn();

            print "procedure returned \n".$myResultId;
            
        }catch(PDOException $e){
            print_r('Query Failed: ' .$e->getMessage());
            return $rows=null;
            exit;
        }
    }*/

    function verifyRequiredParams($inArray, $requiredColumns) {
        $error = false;
        $errorColumns = "";
        foreach ($requiredColumns as $field) {
        // strlen($inArray->$field);
            if (!isset($inArray->$field) || strlen(trim($inArray->$field)) <= 0) {
                $error = true;
                $errorColumns .= $field . ', ';
            }
        }

        if ($error) {
            $response = array();
            $response["status"] = "error";
            $response["message"] = 'Required field(s) ' . rtrim($errorColumns, ', ') . ' is missing or empty';
            echoResponse(200, $response);
            exit;
        }
    }
}

?>
