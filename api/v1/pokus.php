<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();


getLinks();

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    //echo json_encode($response,JSON_NUMERIC_CHECK);        
}

function getLinks() {
	global $db;
    $rows = $db->customQuery("select link.*, tag.ID_tag, tag.name AS tagname From link left join link_tag on link.ID_link = link_tag.ID_link left join tag on link_tag.ID_tag = tag.ID_tag order by link.ID_link ");

    $result = array();
    $result['message'] = $rows["message"];
    $result['status'] = $rows["status"];
	
    $mydata = $rows["data"];
    $tags = array();
    $lastID_link = 0;
    $resultIndex = -1;
    $tagCounter = 0;

    for ($i=0; $i < count($mydata); $i++)
    {
    	if($mydata[$i]['ID_link'] == $lastID_link){
    		// linky se rovnaji - vezmeme tag pokud tam nejaky je a pridame ho do pole tagu do predchoziho resultu
    		if($mydata[$i]['ID_tag'] > 0){
				// link ma tag - pridame ho do stavajiciho pole a prepiseme v resultu
                $tags[$tagCounter]['ID_tag'] = $mydata[$i]['ID_tag']; 
                $tags[$tagCounter]['tagname']= $mydata[$i]['tagname'];  
                $tagCounter++;  	
				$result['data'][$resultIndex]['tags'] = $tags;	
			} 

    	}else{

    		$tags = array();
            $tagCounter = 0;

    		if($mydata[$i]['ID_tag'] > 0){
				// link ma tag, ulozime do pole	
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



    //echo json_encode($result,JSON_NUMERIC_CHECK);
    //print_r $res;
    print_r($result);



}

?>