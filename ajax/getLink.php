<?php 
require_once '../includes/db.php'; // The mysql database connection script

$query="SELECT * FROM link ORDER BY last_modified DESC";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
$return_arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
  
    $arr['URL'] = $row['URL'];
    $arr['name'] = $row['name'];
    $arr['ID_link'] = $row['ID_link'];
    $arr['ID_category'] = $row['ID_category'];
    
    // pribere k tomu i tagy 
    
    $ID_link = $row['ID_link'];          
    $query2="SELECT tag.ID_tag, tag.name FROM tag JOIN link_tag ON link_tag.ID_tag = tag.ID_tag WHERE link_tag.ID_link = $ID_link";
    $result2 = $mysqli->query($query2) or die($mysqli->error.__LINE__);
    $tagarr = array();
    if($result2->num_rows > 0) {
      while($row2 = $result2->fetch_assoc()) {
        $tagarr[] = $row2;		    
      }
      $arr['tags'] = $tagarr;
    }	                       
    $return_arr[] = $arr;
	} 
}

# JSON-encode the response
echo $json_response = json_encode($return_arr);
?>