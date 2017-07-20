<?php
//include('/usr/local/lib/tm/ChromePhp.php');
include '../rest.php';
include  '/usr/local/lib/tm/db.php';
include '../Tbl.php';
$req = RestUtils::processRequest();
$path =$req->getPathArr();
$meth = $req->getMethod();
echo $meth;
print_r( $path);
//ChromePhp::log("in ztest.php");
echo 'in testCurl.php on 162.241';
?>