<?php
 $db = new mysqli("localhost", "root", "", "project");
    
 /* check connection */
 if (mysqli_connect_errno()) {
     header('Location: ..\..\404.php');
     exit();
 }
 
$db->set_charset("utf8");
   
