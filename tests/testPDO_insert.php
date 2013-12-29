<?php
include  '/usr/local/lib/tm/db.php';
include '/var/www/hsc/Tbl.php';
//echo "hello world";
//echo header("Content-type: text/plain");
$feed='80342';
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
$d= array(':afeed'=>$feed, ':circuit'=>$circuit, ':temp'=>$temp, ':relay'=>$relay, ':setpt'=>$setpt, ':time'=>$time);
print_r($d);
print_r($insarr);
echo key($insarr);
$dbo = new db("hsc");
echo("<br/>".$dbo->database);
$tablename='feed';
$tb = new Tbl($tablename, $dbo);

$tb->setInsArr($insarr);

print_r($tb->insWcolon);
print_r($tb->insWcolon[':afeed']);
echo($tb->insFieldStr);
echo($tb->insValStr);
echo $tb->insSql.'<br/>';
$tb->pdo_insert();
$whereArr=array(
	'feed'=>$feed, 
	'ver'=>'prog',
	'ckt'=>4,
	"day"=>6
);	
$tb->setWhereStr($whereArr);
echo $tb->whereStr . '<br/>';
echo $tb->lastInsertId;
?>