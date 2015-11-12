<?php 
  require_once '../includes/db.php'; // The mysql database connection script 
  require_once '../includes/globalFunctions.php';  
  
  $data = json_decode(file_get_contents("php://input"));
  
  if(!empty($data->url)){
   
    $link_url = $data->url;
    
    $link_name = "";
    $link_priority = 0;
    $link_user = 3;
    $link_category = 1;
    $link_tags = array();
                 
    if(!empty($data->name)){
        $link_name = $data->name;
    }
    if(!empty($data->priority)){
        if($data->priority){
          $link_priority = 1;        
        }
    }
    if(!empty($data->category)){
        if($data->category){
          $link_category = $data->category;        
        }
    }
    if(!empty($data->tags)){
        $link_tags = $data->tags;
    }
    if(!empty($data->ID_user)){
    
    }
    
    // ulozime link   
    $link_created = date("Y-m-d H:i:s");
    
    $query="INSERT INTO link(URL, name, ID_user, ID_category, priority, last_modified, deleted)  
            VALUES ('$link_url', '$link_name', '$link_user', '$link_category', $link_priority, '$link_created', 0)";
    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);       
    //$result = $mysqli->affected_rows;     // pocet zmenenych radku
    $newlink_id = $mysqli->insert_id;        
    
    // ulozime i tagy
    if (!empty($link_tags)){
      foreach ($link_tags as &$value) {   
        $tagname =  $value->text;
        $newtag_id = -1;
        
        $query = "SELECT ID_tag FROM tag WHERE name = '$tagname'";
        $result = $mysqli->query($query) or die($mysqli->error.__LINE__);  
        if ($result->num_rows > 0){
            // pouzijeme existuji tag
            $row = $items->fetch_row();
            $newtag_id = $row[0];
        }else{           
            // vytvorime novy           
            $query="INSERT INTO tag(name) VALUES ('$tagname')";
            $result = $mysqli->query($query) or die($mysqli->error.__LINE__);       
            $newtag_id = $mysqli->insert_id;  
        } 
        
        $query="INSERT INTO link_tag(ID_link, ID_tag) VALUES ($newlink_id, $newtag_id)";
        $result = $mysqli->query($query) or die($mysqli->error.__LINE__);            
        echo $json_response = json_encode($result);
   
      }
    }else{
      echo "no tags";
    
    }
       
   
  }else{       
    echo "URL is not set";
  }
?>