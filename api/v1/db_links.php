<?php

function getLinksWithTags() {
   
    global $db;
    
    $whereuserid = "";
    $sess = $db->getSession();
    if($sess){
        if($sess["uid"]>0){
            $whereuserid =  " AND ID_user =".$sess["uid"];
        }
    }
    
    $rows = $db->customQuery("select link.*, tag.ID_tag, tag.name AS tagname From link 
        left join link_tag on link.ID_link = link_tag.ID_link 
        left join tag on link_tag.ID_tag = tag.ID_tag 
        WHERE link.deleted = 0".$whereuserid." ORDER BY link.last_modified DESC ");

    $result = array();
    $result['message'] = $rows["message"];
    $result['status'] = $rows["status"];    
    $mydata = $rows["data"];

    $tags = array();
    $lastID_link = 0;
    $resultIndex = -1;
    $tagCounter = 0;

    // vysledek z databaze chceme prevest do jsonu, kde budou tagy u linku schovane v poli a pridany jako dalsi atribut tags
    for ($i=0; $i < count($mydata); $i++)
    {
        if($mydata[$i]['ID_link'] == $lastID_link){
            // stejny link obsahuje dalsi tag 
            // vezmeme tag a pridame ho do pole tagu do predchoziho resultu
            if($mydata[$i]['ID_tag'] > 0){
                // link ma tag - pridame ho do stavajiciho pole a prepiseme v resultu   
                $tags[$tagCounter]['ID_tag'] = $mydata[$i]['ID_tag']; 
                $tags[$tagCounter]['tagname']= $mydata[$i]['tagname'];  
                $tagCounter++;    
                $result['data'][$resultIndex]['tags'] = $tags;  
            } 

        }else{
            // pridavame unikatni link do resultu, pokud ma tag zapiseme ho 
            $tags = array();
            $tagCounter = 0;

            if($mydata[$i]['ID_tag'] > 0){
                $tags[$tagCounter]['ID_tag'] = $mydata[$i]['ID_tag']; 
                $tags[$tagCounter]['tagname']= $mydata[$i]['tagname'];  
                $tagCounter++;           
            } 
            
            $resultIndex++;
            $lastID_link = $mydata[$i]['ID_link'];

            $result['data'][$resultIndex]['ID_link'] = $mydata[$i]['ID_link'];
            $result['data'][$resultIndex]['name'] = $mydata[$i]['name'];
            $result['data'][$resultIndex]['URL'] = $mydata[$i]['URL'];
            $result['data'][$resultIndex]['deleted'] = $mydata[$i]['deleted'];
            $result['data'][$resultIndex]['last_modified'] = $mydata[$i]['last_modified'];
            $result['data'][$resultIndex]['ID_category'] = $mydata[$i]['ID_category'];
            $result['data'][$resultIndex]['priority'] = $mydata[$i]['priority'];
            $result['data'][$resultIndex]['ID_user'] = $mydata[$i]['ID_user'];      
            $result['data'][$resultIndex]['tags'] = $tags;
        }
    }
    echoResponse(200, $result);
}

function addLinkWithTags(){
    global $app;
    $r = json_decode($app->request->getBody());
    $r->link->last_modified = getmyDate();
    $mandatory = [];
    $table = "link";
    global $db;
    $sess = $db->getSession();
    if($sess){
        if($sess["uid"]>0){
            $r->link->ID_user = $sess["uid"]; 
        }
    }
       
    $result = $db->insert($table, $r->link, array("name","URL","last_modified","priority","ID_category","ID_user"), $mandatory);
    $tagsArray = array();
    if(isset($r->link->tags)){
        if(is_string ($r->link->tags)){
            $tagsArray = explode(",", $r->link->tags); 
        }
    }
      
       
    if ($result["status"] == "success") {
            $response["status"] = "success";
            $response["message"] = "Link created successfully";
        
            // saving tags
            if(isset($result["data"])){
                $lastInsertId = $result["data"];
                if($lastInsertId > 0 && count($tagsArray) > 0){
                    $db->insertTags($tagsArray, $table, $lastInsertId);
                }
            }
            echoResponse(200, $response);
        
    } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create new link. Error: ".$result["message"];
            echoResponse(201, $response);
    }   
   
}

function updateLinkWithTags($id) {
    global $app;
    $r = json_decode($app->request->getBody());
    $r->link->last_modified = getmyDate();
    $condition = array('ID_link'=>$id);
    $mandatory = [];
    $table = "link";
    global $db;
    
    $result = $db->update($table, $r->link, array("name","URL","last_modified","priority","ID_category"), $condition, $mandatory);
    
    $tagsArray = array();
    if(isset($r->link->tags)){
        if(is_string ($r->link->tags)){
            $tagsArray = explode(",", $r->link->tags);
        }
        
    }
        
    if ($result["status"] == "success") {
            $response["status"] = "success";
            $response["message"] = "Link updated successfully";
        
            // saving tags
            if($id > 0){
                // delete all saved tags of this link
                $db->deleteAllTagswithElementID($table, $id);              
                if(count($tagsArray)>0){
                    $db->insertTags($tagsArray, $table, $id);
                }

            }
            echoResponse(200, $response);
        
    } else {
            $response["status"] = "error";
            $response["message"] = "Failed to update link. Error: ".$result["message"];
            echoResponse(201, $response);
    }   
}

function deleteLink($id) {
    global $db;
    $data = array('deleted'=>1);
    $condition = array('ID_link'=>$id);
    $mandatory = [];
    
    $result = $db->update("link", $data, array("deleted"), $condition, $mandatory);
    if ($result["status"] == "success") {
            $response["status"] = "success";
            $response["message"] = "Link deleted successfully";
            echoResponse(200, $response);
    } else {
            $response["status"] = "error";
            $response["message"] = "Failed to delete link. Error: ".$result["message"];
            echoResponse(201, $response);
    }  
}

// unused
/*
function getLinks() {
    global $db;
    $rows = $db->select("link","*",array(),"ORDER BY last_modified");
    echoResponse(200, $rows);
}

function getLink($id) {
    global $db;
    $condition = array('id'=>$id);
    $rows = $db->select("link","*",$condition);

    if($rows["status"]=="success")
        $rows["message"] = "Item find successfully.";
    echoResponse(200, $rows);
}

function updateLink($id) {
    global $app;
    $data = json_decode($app->request->getBody());
    $condition = array('ID_link'=>$id);
    $mandatory = [];
    global $db;
    $rows = $db->update("link", $data, $condition, $mandatory);
    echoResponse(200, $rows);

}
function addLink(){
        
    global $app;
    $data = json_decode($app->request->getBody());
    $mandatory = [];
    global $db;
    $rows = $db->insert("link", $data, $mandatory);
    echoResponse(200, $rows);

}
*/

?>