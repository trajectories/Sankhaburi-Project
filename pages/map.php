<?php
// redirect ไปที่ browser ที่เปิด google map
if (isset($_GET['map'])) {
  $map = $_GET['map'];
  header("Location: $map");
  exit;
}
?>
