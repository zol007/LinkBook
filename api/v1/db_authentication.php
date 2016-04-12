<?php 
require_once 'passwordHash.php';


function returnSession() {
    global $db;
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    echoResponse(200, $session);
}

function login() {    
    
    global $app;
    global $db;
    $r = json_decode($app->request->getBody());
    $db->verifyRequiredParams($r->user, array('email', 'password'));
    $response = array();
    $password = $r->user->password;
    $email = $r->user->email;
    
    $result = $db->select("user","ID_user,name,password,email,created",array('email'=>$email),"LIMIT 1");
    $user = $result["data"][0];
    require_once 'passwordHash.php';
    
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['name'];
        $response['uid'] = $user['ID_user'];
        $response['email'] = $user['email'];
        $response['createdAt'] = $user['created'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['ID_user'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['name'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
}

function signup(){
    global $app;
    global $db;
    
    $response = array();
    $r = json_decode($app->request->getBody());
    $db->verifyRequiredParams($r->user, array('email', 'name', 'password'));
    require_once 'passwordHash.php';
    $name = $r->user->name;
    $email = $r->user->email;
    $password = $r->user->password;
    $r->user->created = getmyDate();
    
    $isUserExists = $db->customQuery("select 1 from user where email='$email' LIMIT 1");
    
    if(!$isUserExists["data"]){
        $r->user->password = passwordHash::hash($password);
        $table_name = "user";
        $column_names = array('email', 'name', 'password', 'created');
        $mandatory = [];
        
        $result = $db->insert($table_name, $r->user, $column_names, $column_names);
        
        if ($result["data"] != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result["data"];
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create user. Error: ".$result["message"];
            echoResponse(201, $response);
        }            
        
        
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
}

function logout() {
    global $db;
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
}




?>