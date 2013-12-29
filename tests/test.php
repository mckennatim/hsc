<?php
//echo header("Content-type: text/plain");
include  '/usr/local/lib/tm/db.php';
$feed=80234;
$circuit="ckt0";
$insarr=array('feed'=>$feed, 'circuit'=>$circuit);
print_r($insarr);
echo key($insarr);
$dbo = new db("hsc");
echo("<br/>".$dbo->user);
$tbo = new tbl("feed", $dbo);
echo("<br/> duck ". $tbo->db->pass);
echo ($tbo->getPrimary());
$feed="9ss99";
$circuit="ckt222";
$temp=555;
$relay=1;
$setpt=111;
$time = time();

$insarr=array(
	'feed'=>$feed, 
	'circuit'=>$circuit,
	"temp"=>$temp,
	"relay"=>$relay,
	"setpt"=>$setpt,
	"time"=>$time
	);
	

$tbo->setInsArr($insarr);	
print_r($tbo->insarr);
//$tbo->pdo_insert();	
$lr =	$tbo->getLastRec();
	$lasttime= $lr['time'];
	echo $lasttime;
print_r($lr);
$wherestr= 'time = '.$lr["time"];
echo("<br/> ". $wherestr."<br/> ");
$ibr =$tbo->selectWhere($wherestr);
print_r($ibr);
$temp=319;
$relay=0;
$setpt=153;
$i=2;
			if($temp != $ibr[$i]['temp'] || $relay != $ibr[$i]['relay'] || $setpt != $ibr[$i]['setpt']){
				echo("<br/>different");
			}else{
				echo("<br/>same");
			}
echo("<br/> finished");
?>