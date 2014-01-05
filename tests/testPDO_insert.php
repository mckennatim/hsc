<?php
include  '/usr/local/lib/tm/db.php';
include '/var/www/hsc/Tbl.php';
$feed='80999';
$circuit='ckt2';
$temp=234;
$relay = 0;
$setpt = 142;
$time= 1388113333;
$insarr=array(
	'afeed'=>$feed, 
	'circuit'=>$circuit,
	"temp"=>$temp,
	"relay"=>$relay,
	"setpt"=>$setpt,
	"time"=>$time
); 
$dbo = new db("hsc");
$tablename='feed';
$tb = new Tbl($tablename, $dbo);
$tb->setInsArr($insarr);
$tb->pdo_insert();
$whereArr=array(
	'feed'=>$feed, 
	'ver'=>'prog',
	'ckt'=>4,
	"day"=>6
);	
$tb->setWhereStr($whereArr);
?>