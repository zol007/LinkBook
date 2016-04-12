<?php
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';
require_once 'passwordHash.php';

require_once 'db_links.php';
require_once 'db_authentication.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();

/**
 * Database Helper Function templates
 */

$app->get('/categories', 'getCategories');

$app->get('/links', 'getLinksWithTags');
$app->post('/link', 'addLinkWithTags');
$app->put('/link/:id', 'updateLinkWithTags');
$app->delete('/link/:id', 'deleteLink');

$app->get('/session', 'returnSession');
$app->post('/login', 'login');
$app->post('/signUp', 'signup');
$app->get('/logout', 'logout');

//$app->get('/links/search/:query', 'findByName');
//$app->get('/link/tags:idlink', 'getLinkTags');

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

function getmyDate(){
    return date("Y-m-d H:i:s");
}

// CATEGORIES
function getCategories() {
    global $db;
    $rows = $db->select("category","*",array(),"ORDER BY name");
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


$app->run();


?>