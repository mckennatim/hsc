<?php 
$id = $_GET['id'];
$url = $_SERVER['REQUEST_URI'];
$urlarr = parse_url($url);
$pathstr=substr($urlarr["path"],1);
$patharr= explode("/", $pathstr);
echo "in show.php </br>";
echo $pathstr ."</br>";
echo $id;
 ?>