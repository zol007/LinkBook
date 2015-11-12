<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();

/**
 * Database Helper Function templates
 */
/*
select(table name, where clause as associative array)
insert(table name, data as associative array, mandatory column names as array)
update(table name, column names as associative array, where clause as associative array, required columns as array)
delete(table name, where clause as array)
*/
$app->get('/categories', 'getCategories');

//$app->get('/links', 'getLinks');
// get products


//$app->get('/links/:id', 'getLink');
//$app->get('/links/search/:query', 'findByName');

$app->get('/links', 'getLinksWithTags');
$app->post('/link', 'addLinkWithTags');
$app->put('/link/:id', 'updateLinkWithTags');
$app->delete('/link/:id', 'deleteLink');

//$app->get('/link/tags:idlink', 'getLinkTags');

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);        
}

// CATEGORIES
function getCategories() {
    global $db;
    $rows = $db->select("category","*",array(),"ORDER BY name");
    echoResponse(200, $rows);
}

// LINKS

function getLinksWithTags() {
   
    global $db;
    $rows = $db->customQuery("select link.*, tag.ID_tag, tag.name AS tagname From link 
        left join link_tag on link.ID_link = link_tag.ID_link 
        left join tag on link_tag.ID_tag = tag.ID_tag 
        WHERE link.deleted = 0 ORDER BY link.last_modified DESC ");

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
    $data = json_decode($app->request->getBody(), true);
    $data['last_modified'] = getmyDate();
    $data['deleted'] = 0;
    $mandatory = [];
    global $db;
    $rows = $db->insertwithTags("link", $data, $mandatory);
    echoResponse(200, $rows);

}

function updateLinkWithTags($id) {
    global $app;
    $data = json_decode($app->request->getBody(), true);
    $data['last_modified'] = getmyDate();
    $data['deleted'] = 0;
    $condition = array('ID_link'=>$id);
    $mandatory = [];
    global $db;
    $rows = $db->updatewithTags("link", $data, $condition, $mandatory);
    echoResponse(200, $rows);

}


function deleteLink($id) {
    global $db;
    $data = array('deleted'=>1);
    $condition = array('ID_link'=>$id);
    $mandatory = [];
    $rows = $db->update("link", $data, $condition, $mandatory);
    echoResponse(200, $rows);

}

// TAGS

function getLinkTags($idlink) {
    global $db;
    $rows = $db->select("tag","*",array(),"");
    echoResponse(200, $rows);
}
function getKnowTags($idknow) {
    global $db;
    $rows = $db->select("tag","*",array('ID_tag'=>1),"");
    echoResponse(200, $rows);
}


function getmyDate(){
    return date("Y-m-d H:i:s");
}


// unused

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



$app->run();


?>