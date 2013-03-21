<?php
require_once 'engine/Queue.php';


$queue = new Queue();


$action = $_GET['action'];
$timestamp = isset($_GET['timestamp']) ? floatval($_GET['timestamp']) : null;
switch($action){
    case 'get':
        header("Content-type: text/json");
        echo json_encode($queue->Pop($timestamp));
        break;
    case 'post':
        $latitude = $_GET['latitude'];
        $longitude = $_GET['longitude'];
      
        if(preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', "$latitude, $longitude")){
            $queue->Push($latitude, $longitude, microtime(true));
            echo "success";
        }else{
            echo "Invalid Format";
        }
        break;
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
