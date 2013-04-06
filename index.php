<?php
include 'rest.php';
include  '/usr/local/lib/tm/db.php';
//include('/usr/local/lib/tm/ChromePhp.php');
echo header("Content-type: text/plain");
//$qs=$_SERVER['QUERY_STRING'];
//echo("duck\n\n ".$qs);
//echo("\n\n".$_GET['room']."\n\n");
ChromePhp::log("in index.php");

$req = RestUtils::processRequest();
$path =$req->getPathArr();
$now = $req->getTimeStamp();
$type = $path[1];//feed or prog or boho
$feed = $path[2];	//the feed number
$data=$req->getData();
$db = new db($path[0]);
$params = array();
$params['MAXCKTS']=12;
$progArr= array(1,1,1,1,1,1,1,0,0,0,0,0);
$params['programmable']=$progArr;
$params['defaultLo']=57;
//$db->setDb($path[0]);
//$retSetptStr="\n\n<[1180,3182,4173,5174,6176]>\n";
//$retSetptStr="<[130,130,130,0 ,0,130,0,0,160,169, 170,190]>\n";
//echo($req->getMethod());
/*
198.23.156.78/hsc/feed/80302?room=all

print_r($req->getHttpAccept());
print_r($req->getJson());
print_r($req->getHttpHeaders());
print_r($req->getPathArr());
print_r($req->getData()); 
echo $json."\n\n";
echo $req->getTimeStamp() ."\n"; 
echo date('l jS \of F Y h:i:s A', $req->getTimeStamp()). "\n\n";
*/

switch($req->getMethod())
	{
	case 'get':
	/*
		GET request to /prog/80302/ – get progs for all locations
		GET request to /prog/80302/5 – get progs for location
		GET request to /boho/80302/ – get all holds for feed
		GET request to /prog/80302/3 – get prog for feed's sensor
		GET request to /state/80302/3 – get state of feed's sensor
		GET request to /state/80302/ – get state for all
		GET request to /zone/80302/ – get all zone info
		GET request to /zone/80302/3 – get info for zone 3
		GET request to /feed/– get list of all feeds
		GET reqiuest to /feed/80302 - get list of sensors/states names for feed
		GET request to /feed/80302/sensor/where – get feed for sensor/state of feed
		*/	
		switch($type){
			case 'feed':
				break;
			case 'prog':
				$progdat=array();
				$ver=$path[3];
				$progTbl = new tbl("progs", $db);
				$ckts= array();
				for ($i=0;$i<$params['MAXCKTS'];$i++){
					$days=array();
					for ($j=0;$j<7;$j++){
						$whereArr=array(
							'feed'=>$feed, 
							'ver'=>$ver,
							'ckt'=>$i,
							"day"=>$j
						);
						$progTbl->fieldStr='`clock`, `setpt`';
						$progTbl->setWhereStr($whereArr);
						$days[$j]=$progTbl->selectWhere();
					}
					$ckts[$i]=$days;
				}
				$progdata[$feed][$ver]=$ckts;
				$progJSON= '{"items":'. json_encode($progdata) .'}';
				//print_r($progdata);
				echo($progJSON);
				break;
			case 'boho':
				$boholist = getBohoList($db, $path);
				$bohoListJSON= '{"items":'. json_encode($boholist) .'}';
				echo($bohoListJSON);			
				break;
			case 'zone':
				$zonelist = getZoneList($db, $feed);
				$zoneListJSON= '{"items":'. json_encode($zonelist) .'}';
				echo($zoneListJSON);
				break;
			case 'state':
				$allroomdata = getAllRoomData($db, $feed);
				$allRoomJSON= '{"items":'. json_encode($allroomdata) .'}';
				echo($allRoomJSON);
				break;									
		}

		/*
		foreach($data as $key=>$val){}
		switch($key){
			case 'room':
				$room = $data['room'];
				if (strlen($room) == 0){
					//echo("list rooms");
					$roomlist = getRoomList($db, $feed);
					$roomListJSON= '{"items":'. json_encode($roomlist) .'}';
					echo($roomListJSON);
				}else if ($room=='all'){
					//echo("list all room data");
					$allroomdata = getAllRoomData($db, $feed);
					$allRoomJSON= '{"items":'. json_encode($allroomdata) .'}';
					echo($allRoomJSON);
					//print_r($allroomdata);
				}else{
					print_r($req->getHttpHeaders());
					$roomdata = getRoomData($room, $db, $feed);
					$roomJSON= '{"items":'. json_encode($roomdata) .'}';
					echo($roomJSON);			
					print_r($roomdata);
					$ftemp= $roomdata['temp']/16*9/5+32;
					$stemp =$roomdata['setpt']/8*9/5+32;
						if($roomdata['relay']==0){$zoneis = 'off';}else{$zoneis='on';}
					$outstr = "The ". $roomdata['room']." temperature was ". $ftemp. " at ". date('l jS \of F Y h:i:s A', $req->getTimeStamp()). ". The thermostat is set to ".$stemp.  " and this zone is ".$zoneis;
					echo($outstr);	
				}
				break;
			case 'prog':
				if (!strcmp($val,'all')){
					$progdata = getProgs($db, $feed);
					$progJSON= '{"items":'. json_encode($progdata) .'}';
					echo($progJSON);
				}
				break; 	
		} */
		break;
	case 'post':
		/* a get like list query string feef=80302&type=prog
		POST request to /feed – Create a new feed
		POST request to /prog/feed -create a new prog for feed
		POST request to /prog/ -create a new location	*/
		switch($type){
			case 'feed':
				break;
			case 'prog':
				break;
			case 'boho':
				break;
			case 'zone':
				break;
			case 'state':
				break;									
		}		
		print_r($data);
		echo("a post request"); 
		break;
	case 'put'://consists of complex data structure
	/*	PUT request to /prog/80302/sensor – Update progs for feed's sensor
		PUT request to /prog/80302 – Update all progs for feed
		PUT request to /prog/loc – Update progs for all locations
		PUT request to /prog/loc/peri_study – Update progs for location	  */	
		/*PUT request to /feed/80308 – Update feed with additional data */		
		switch($type){
		case 'feed':
			//echo("\nin case:put, case:feed of index.php, sending this back to microcontroller\n");
			getTodayLTEnow($db, $path);
			$se = getSetptArr($db, $path);
			//echo($se);
			ckHolds($db, $path);
			$se = getSetptArr($db, $path);
			$se=addDefIfprog0($se);
			echo setptA2J($se);
			zeroSetptArr($db, $path);					
			//echo($retSetptStr);//"\n<0151,1152,2153>\n"
			/*PUT request to /feed/80308 – Update feed with additional data */	
			$timestamp = $req->getTimeStamp();				
			$tbo = new tbl("feed", $db);
			$data=$req->getData();
			//echo "soulld be about to print data";	
			//print_r($data);	
			$ibr =getLastCktEntries($db,$feed);	//object of last entries
			$jibr=json_encode($ibr[0]);
			//echo($jibr);	
			$i=0;	
			for($i=0;$i<$params['MAXCKTS'];$i++){						
				$temp= $data['data']['temp'][$i];
				$relay = $data['data']['relay'][$i];
				$setpt = $data['data']['setpt'][$i];
				$circuit = "ckt".$i;
				echo $i. " temp=".$temp." dtemp=".$ibr[$i]['temp'].", relay=".$relay." drelay=".$ibr[$i]['relay'].", setpt=".$setpt." dsetpt=".$ibr[$i]['setpt']."\n";			
				//if($temp - $ibr[$i]['temp']!=0 || $relay - $ibr[$i]['relay'] !=0|| $setpt - $ibr[$i]['setpt']!=0)	
				if($temp != $ibr[$i]['temp'] || $relay != $ibr[$i]['relay'] || $setpt != $ibr[$i]['setpt']){
					//update database only if temp, relay or setpt have changed;
					echo $i. " has changed and will be updated to \n";
					$insarr=array(
						'afeed'=>$feed, 
						'circuit'=>$circuit,
						"temp"=>$temp,
						"relay"=>$relay,
						"setpt"=>$setpt,
						"time"=>$timestamp
					);
					// get prior data to see if it has changed		
					$tbo->setInsArr($insarr);	
					print_r($insarr);
					//echo "before pdo_insert\n";
					$tbo->pdo_insert();				
				}
			}					
			break;	
		case 'boho':
			/*	PUT request to /boho/80302/sensor# – place hold for feed's sensor
				PUT request to /boho/80302 – place holds for all sensors for feed */			
			$sensor=$path[3];
			echo($sensor." yo in case:boho of index.php");
			//$data=json_decode('{"start":1363707975,"finish":1363688100,"setpt":167}',true);
			print_r($data);
			insertHold($db,$path,$data);				
			echo $setptJ;			
			break;	
		case 'prog':
			/*	PUT request to /prog/80302/ver/ckt/day*/	
			$progs = new tbl("progs", $db);
			$ver=$path[3];
			$feed=$path[2];	
			if (strlen($path[4]==0))	{//PUT request to /prog/80302/ver/ all ckts and all days for those ckts
				echo "PUT request to /prog/80302/ver/ all ckts and all days for those ckts deleteWhere() then pdo_insert()\n";
				print_r(($data[1][5])); 
				for ($i=0;$i<$params['MAXCKTS'];$i++){
					for ($j=0;$j<7;$j++){
						$whereArr=array(
							'feed'=>$feed, 
							'ver'=>$ver,
							'ckt'=>$i,
							"day"=>$j
						);	
						//print_r($whereArr);
						//function replEntries4dc($db, $dc)
						$progs->setWhereStr($whereArr);
						$progs->deleteWhere();						
						$titeArr=$data[$i][$j];

						if (!is_null($titeArr)){
							foreach ($titeArr as $tite) {
								$dc=array(
									'feed'=>$feed, 
									'ver'=>$ver,
									'ckt'=>$i,
									"day"=>$j,
									"setpt"=>$tite['setpt'],
									"clock"=>$tite['clock']
								);
								print_r($dc);
								$progs->setInsArr($dc);	
								$progs->pdo_insert();
							}							
						}

					}
				}
			}else{
				if (!strcmp($path[4],'99')){//PUT request to /prog/80302/ver/99/5, multiple ckts for day 5
					echo "PUT request to /prog/80302/ver/99/5, multiple ckts for day 5\n";
					print_r(count($data['ckts'][11][5])); 
					$day=5;
					for ($i=0;$i<$params['MAXCKTS'];$i++){
						if(count($data['ckts'][$i][$day])>0){
							$dc=array(
								'feed'=>$feed, 
								'ver'=>$ver,
								'ckt'=>$i,
								"day"=>$day,
								"setpt"=>$data['ckts'][$i][$day]['setpt'],
								"clock"=>$data['ckts'][$i][$day]['time']
							);
							$whereArr=array(
								'feed'=>$feed, 
								'ver'=>$ver,
								'ckt'=>$i,
								"day"=>$day
							);	
							//function replEntries4dc($db, $dc)
							$progs->setWhereStr($whereArr);
							$progs->deleteWhere();
							$progs->setInsArr($dc);	
							$progs->pdo_insert();	
						}
					}					
				}else {
					if (strlen($path[5]==0))	{//PUT request to /prog/80302/ver/4/, multiple days for ckt 5
						echo "PUT request to /prog/80302/ver/4/, multiple days for ckt 4\n";
						print_r(count($data['ckts'][11][5])); 
						$ckt=4;
						for ($j=0;$j<7;$j++){
							if(count($data['ckts'][$ckt][$j])>0){
								$dc=array(
									'feed'=>$feed, 
									'ver'=>$ver,
									'ckt'=>$ckt,
									"day"=>$j,
									"setpt"=>$data['ckts'][$ckt][$j]['setpt'],
									"clock"=>$data['ckts'][$ckt][$j]['time']
								);
								$whereArr=array(
									'feed'=>$feed, 
									'ver'=>$ver,
									'ckt'=>$ckt,
									"day"=>$j
								);	
								//function replEntries4dc($db, $dc)
								$progs->setWhereStr($whereArr);
								$progs->deleteWhere();
								$progs->setInsArr($dc);	
								$progs->pdo_insert();	
							}
						}					
					} else {//PUT request to /prog/80302/ver/4/5, day 5 for ckt 4
						echo"PUT request to /prog/80302/ver/4/5, day 5 for ckt 4\n";
						print_r(count($data['ckts'][11][5])); 
						$ckt=4;
						$day=5;
						if(count($data['ckts'][$ckt][$day])>0){
							$dc=array(
								'feed'=>$feed, 
								'ver'=>$ver,
								'ckt'=>$ckt,
								"day"=>$day,
								"setpt"=>$data['ckts'][$ckt][$day]['setpt'],
								"clock"=>$data['ckts'][$ckt][$day]['time']
							);
							$whereArr=array(
								'feed'=>$feed, 
								'ver'=>$ver,
								'ckt'=>$ckt,
								"day"=>$day
							);	
							//function replEntries4dc($db, $dc)
							$progs->setWhereStr($whereArr);
							$progs->deleteWhere();
							$progs->setInsArr($dc);	
							$progs->pdo_insert();	
						}					
					}
				}
			}
			break;				
		}
		echo("\na put request has been put\n\n"); 
		break;	
	case 'delete':
	/*			
		DELETE request to /feed/80308 – Delete feed
		DELETE request to /prog/loc – Delete all progs for feed
		DELETE request to /prog/80308 – Delete all progs for feed 
		DELETE request to /boho/80308 – Delete all boosts or holds
		DELETE request to /boho/80308/4 – Delete boost/hold for ckt */
		switch($type){
			case 'feed':					
				echo("a delete:feed request\n\n"); 
				break;	
			case 'prog':					
				echo("a delete:prog request\n\n"); 
				break;	
			case 'boho':	
				$ckt=$path[3];
				
				delHold($db, $feed, $ckt);		
				echo($feed. " a delete:boho request".$ckt."\n\n"); 
				break;									
		}
}
/*
function getProgs($db, $feed){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT * FROM progs WHERE feed="'.$feed.'" ORDER BY ver, ckt, day, clock';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		//print_r($result);
		return $result;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}
*/
function getZoneList($db, $feed){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT * FROM rooms WHERE feed="'.$feed.'"';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		//print_r($result);
		return $result;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}
}	

function getRoomData($room, $db, $feed){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT * FROM `feed` LEFT JOIN rooms USING(circuit) WHERE room= "'.$room. '" AND afeed="'.$feed.'"ORDER BY `time` DESC LIMIT 1';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}
}	

function getAllRoomData($db, $feed){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT * FROM `rooms` 
LEFT JOIN(
SELECT t1.*, room as oldroom, defsetpt FROM `feed` t1
LEFT JOIN rooms USING(circuit) 
INNER JOIN 
      (SELECT
     afeed  
     , circuit
     , MAX(time) AS MAXDATESTAMP
   FROM feed
   GROUP BY afeed, circuit   
  ) AS t2
ON t1.afeed = t2.afeed
AND t1.circuit = t2.circuit
AND t1.time = t2.MAXDATESTAMP  
WHERE t1.afeed = "'.$feed.'"	) AS t3 USING(circuit) ';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $result;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}
}

function getLastCktEntries($db,$feed){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT t1.*, substring(t1.circuit,4)+0 as orde FROM `feed` t1
INNER JOIN 
      (SELECT
     afeed  
     , circuit
     , MAX(time) AS MAXDATESTAMP
   FROM feed
   GROUP BY afeed, circuit   
  ) AS t2
ON t1.afeed = t2.afeed
AND t1.circuit = t2.circuit
AND t1.time = t2.MAXDATESTAMP  
WHERE t1.afeed = "'.$feed.'"	
ORDER BY orde ';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}

function updateSetptArr($db, $feed, $sensor,$setpt){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  ='UPDATE `setptArr`  SET `setpt` = '.$setpt. '  WHERE `feed`="'.$feed.'" AND `sensor`= '.$sensor;
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}	

function addDefIfprog0($se){
	global $params;
	$ar = $params['programmable'];
	$lo = $params['defaultLo'];
	for ($i=0;$i<$params['MAXCKTS'];$i++){
		//echo ($ar[$i].' '.$se[$i]."\n");
		if($ar[$i]==1 && $se[$i]==0){
			$se[$i]=f2setpt($lo);
		}
	}
	return $se;
}

function setptA2J($se){
		$sse = json_encode($se);
		$sse = preg_replace( "/\"(\d+)\"/", '$1', $sse );//remove quotes from numbers
		$sse = "\n<".$sse.">\n";
		return $sse;
}

function getSetptArr($db, $path){
	$feed =$path[2];
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  ='SELECT `setpt` FROM `setptArr` WHERE `feed`="'.$feed.'"'; 
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$se = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $se;
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}


function zeroSetptArr($db, $path){
	$feed =$path[2];
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  ='UPDATE `setptArr`  SET `setpt` = 0  WHERE `feed`="'.$feed.'"';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}

function delProg($db,$path){
	$feed =$path[2];
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  ='DELETE FROM `progs` WHERE `feed`="'.$feed.'" AND `ver` = "current"'  ;
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}	
function newProg($db, $path, $data){

}
function replEntries4dc($db, $data){
    
}

function getTodayLTEnow($db, $path){
	//echo("get Today LTE now ");
	$status=array();
	$now = time();
	$dow = date( "w", $now);
	$ti = date("H:i:s", $now);
	$type  = $path[1];//feed or prog or
	$feed = $path[2];	//the feed number
	//echo ($now);
	//$data=$req->getData();	
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT ckt, setpt , MAX( clock ) FROM progs WHERE ver="current" AND feed ="'.$feed.'" AND day="'.$dow.'" AND clock<"'.$ti.'" GROUP BY ckt ORDER BY ckt, clock DESC';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		while($result = $stmt->fetch()){
			$ckt=$result['ckt'];
			$setpt =f2setpt($result['setpt']);
			//echo("\n".$ckt."  ".$setpt."");
			updateSetptArr($db, $feed, $ckt, $setpt);
		}
		//echo("\n\n".$sql."\n\n");
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}

function ckHolds($db, $path){
	//echo("in ckHolds ");
	$status=array();
	$now = time();
	$type  = $path[1];//feed or prog or
	$feed = $path[2];	//the feed number
	//echo ($now);
	//$data=$req->getData();	
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT DISTINCT `ckt`, `setpt`, `finish` FROM `holds`  WHERE feed="'.$feed.'" AND `start`<='.$now. ' AND `finish`>'.$now;
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		while($result = $stmt->fetch()){
			$ckt=$result['ckt'];
			$setpt =f2setpt($result['setpt']);
			$finish = $result['finish'];
			$status[$ckt]['setpt']=$setpt;
			$status[$ckt]['finish']=$finish;
			updateSetptArr($db, $feed, $ckt,$setpt);
		}
		//print_r($status);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}

function getBohoList($db, $path){
	$bohoA=array();
	$bohoA[11]=null;
	$now = time();
	$type  = $path[1];//feed or prog or
	$feed = $path[2];	//the feed number
	//echo ($now);
	//$data=$req->getData();	
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  = 'SELECT DISTINCT `ckt`, `setpt`, `start`, `finish` FROM `holds`  WHERE feed="'.$feed.'" AND `start`<='.$now. ' AND `finish`>'.$now.' ORDER BY ckt'; ;
		$stmt = $dbh->prepare($sql);
		$stmt->execute();	
		while($result = $stmt->fetch()){
			$ckt=$result['ckt'];
			$setpt =$result['setpt'];
			$start = $result['start'];
			$finish = $result['finish'];
			$bohoA[$ckt]['setpt']=$setpt;
			$bohoA[$ckt]['start']=$start;
			$bohoA[$ckt]['finish']=$finish;
		}
		//echo($sql);
		return $bohoA;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}		
}

function insertHold($db, $path, $data){
	global $params;
	$tbo = new tbl("holds", $db);
	$data['feed']= $path[2];
	//echo("\n in insert0Hold path[3]=".$path[3]."\n");
	if (!strcmp(trim($path[3]),'99')){
		//echo("pathis99");
		for($i=0;$i<$params['MAXCKTS'];$i++){
			echo($i);
			$data['ckt']= $i;	
			delHold($db, $data['feed'], $data['ckt']);
			$tbo->setInsArr($data);
			$tbo->pdo_insert();		
		}	
	}else{
		$data['ckt']= $path[3];	
		delHold($db, $data['feed'], $data['ckt']);
		$tbo->setInsArr($data);
		$tbo->pdo_insert();			
	}
}

function delHold($db, $feed, $ckt){
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if (!strcmp($ckt,'99')){
			$sql  ='DELETE FROM `holds` WHERE `feed`="'.$feed.'"'  ;
		}else{
			$sql  ='DELETE FROM `holds` WHERE `feed`="'.$feed.'" AND `ckt` = "'.$ckt.'"'  ;
		}
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .$sql.'}}'; 
	}	
}

function f2setpt($ftemp){
	 $atemp= round(($ftemp-32)*8*5/9);    
    return $atemp;
}

	/*
	$data = $req->getData();  jsonArray
json{"data": {"temp": [844, 622], "relay": [0, 1 ], "setpt": [302, 283]}}
     [data] => Array
        (
            [temp] => Array
                (
                    [0] => 844
                    [1] => 622
                )

            [relay] => Array
                (
                    [0] => 0
                    [1] => 1
                )

            [setpt] => Array
                (
                    [0] => 302
                    [1] => 283
                )
    )
    [0] => hsc
    [1] => feed
    [2] => 80230
)
{"data": {"temp": {"sensor2":844, "sensor3":622}, "relay": { "re4":437, "re5":439} , "setpt": {"set1": 302, "set2": 283}}}

	*/
?>