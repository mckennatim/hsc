<?php
echo header("Content-type: text/plain");
include  'index.php';

$feed='80302';
$path[2]=$feed;
$path[1]='progs';
print_r($path);
print_r($data);
$progs='{"80302":{"current":[[[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"},{"clock":"22:30","setpt":"61"}],[{"clock":"06:06","setpt":"69"},{"clock":"10:30:00","setpt":"67"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"18:30","setpt":"69"},{"clock":"22:30","setpt":"61"}],[{"clock":"00:30","setpt":"62"},{"clock":"06:06","setpt":"69"},{"clock":"12:30","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"10:30:00","setpt":"61"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}]],[[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[]],[[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"},{"clock":"22:30","setpt":"61"}],[{"clock":"06:06","setpt":"69"},{"clock":"10:30:00","setpt":"67"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"18:30","setpt":"69"},{"clock":"22:30","setpt":"61"}],[{"clock":"00:30","setpt":"62"},{"clock":"06:06","setpt":"69"},{"clock":"12:30","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"10:30:00","setpt":"61"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}]],[[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"},{"clock":"22:30","setpt":"61"}],[{"clock":"06:06","setpt":"69"},{"clock":"10:30:00","setpt":"67"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"18:30","setpt":"69"},{"clock":"22:30","setpt":"61"}],[{"clock":"00:30","setpt":"62"},{"clock":"06:06","setpt":"69"},{"clock":"12:30","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"10:30:00","setpt":"61"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}]],[[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"},{"clock":"22:30","setpt":"61"}],[{"clock":"06:06","setpt":"69"},{"clock":"10:30:00","setpt":"67"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"18:30","setpt":"69"},{"clock":"22:30","setpt":"61"}],[{"clock":"00:30","setpt":"62"},{"clock":"06:06","setpt":"69"},{"clock":"12:30","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"05:30","setpt":"67"},{"clock":"10:30:00","setpt":"67"},{"clock":"10:30:00","setpt":"61"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}]],[[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[]],[[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"01:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"57"},{"clock":"10:30:00","setpt":"67"},{"clock":"13:30:00","setpt":"57"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}],[{"clock":"06:06","setpt":"69"},{"clock":"21:06","setpt":"59"}]],[[],[],[],[],[],[],[]],[[],[],[],[],[],[],[]],[[],[],[],[],[],[],[]],[[],[],[],[],[],[],[]],[[{"clock":"10:30:00","setpt":"157"},{"clock":"10:30:00","setpt":"157"}],[],[],[],[],[],[{"clock":"10:30:00","setpt":"157"},{"clock":"10:30:00","setpt":"157"}]]]}}';
$progAlls=json_decode($progs,true);

foreach($progAlls as $feed=>$dataF){
	;
}
foreach($dataF as $ver=>$data){
	;
}

echo($feed."  ".$ver."\n\n");
//print_r($data[$feed][$current]);
//print_r($data);
$ts=time();
$dow=date( "w", $ts);

$ti = date("H:i:s", $ts);
echo($dow);
echo($ti);
 
$ftemp=57;
function f2esetpt($ftemp){
	 $atemp= round(($ftemp-32)*8*5/9);    
    return $atemp;
}
echo("\n\n".f2setpt($ftemp));
getTodayLTEnow($db, $path);
$se = getSetptArr($db, $path);
$se=addDefIfprog0($se);
echo setptA2J($se);
ckHolds($db, $path);
$se = getSetptArr($db, $path);
echo setptA2J($se);
//print_r(getBohoList($db, $path));
$bohoList = getBohoList($db, $path);
$bohoListJSON= '{"items":'. json_encode($bohoList) .'}';
echo($bohoListJSON);
print_r($bohoList);
?>