<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);
// สร้าง connection ไปยัง database ที่ชื่อว่า project  โดยใช้ username: root และ password: ว่าง
$db = new mysqli("localhost", "root", "", "project");

/* check connection */
if (mysqli_connect_errno()) {
    header('Location: ..\..\404.php');
    exit();
}
// กำหนด charset เป็น utf8 ให้ใช้กับภาษาไทยได้
$db->set_charset("utf8");
