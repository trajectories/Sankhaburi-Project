<?php
if (isset($_GET['map'])) {
  $map = $_GET['map'];
  header("Location: $map");
  exit;
}
?>
