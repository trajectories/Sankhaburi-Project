<?php
 $db = new mysqli("localhost", "root", "", "tourist_attractions");
    
 /* check connection */
 if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
 }
 
 /* change character set to utf8 */
 if (!$db->set_charset("utf8")) {
     printf("Error loading character set utf8: %s\n", $db->error);
 } else {
     printf("Current character set: %s\n", $db->character_set_name());
 }
   
 $db->close();