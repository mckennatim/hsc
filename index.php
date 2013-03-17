<?php
echo header("Content-type: text/plain");
//$qs=$_SERVER['QUERY_STRING'];
//echo("duck\n\n ".$qs);
//echo("\n\n".$_GET['room']."\n\n");
include 'rest.php';
include  '/usr/local/lib/tm/db.php';

$req = RestUtils::processRequest();
$path =$req->getPathArr();
$type  = $path[1];//feed or prog or
$feed=$path[2];	//the feed number
$data=$req->getData();
$db = new db($path[0]);
//$db->setDb($path[0]);
//$retSetptStr="\n\n<[1180,3182,4173,5174,6176]>\n";
$retSetptStr="<[130,130,130,0 ,0,130,0,0,160,169, 170,190]>\n";
//just a bunch of not really needed stuff
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
		GET request to /prog/80302/loc – get progs for all locations
		GET request to /prog/80302/loc/peri_study – get progs for location
		GET request to /prog/80302– get all progs for feed
		GET request to /prog/80302/sensor – get prog for feed's sensor
		GET request to /feed/– get list of all feeds
		GET reqiuest to /feed/80302 - get list of sensors/states names for feed
		GET request to /feed/80302/sensor/where – get feed for sensor/state of feed
		*/	
		//echo("a get request with this data \n\n");
		//print_r($data);
		//print_r($path);
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
	case 'post':
		/*
		POST request to /feed – Create a new feed
		POST request to /prog/loc -create a new prog for location
		POST request to /prog/ -create a new location	*/
		echo("a post request"); 
		break;
	case 'put':
	/*	PUT request to /prog/80302/sensor – Update progs for feed's sensor
		PUT request to /prog/80302 – Update all progs for feed
		PUT request to /prog/loc – Update progs for all locations
		PUT request to /prog/loc/peri_study – Update progs for location	  */	
		/*PUT request to /feed/80308 – Update feed with additional data */		
		switch($type){
			case 'feed':
				echo("\nin case:put, case:feed of index.php, sending this back to microcontroller\n");
				$se = getSetptArr($db, $path);
				echo $se;
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
				for($i=0;$i<12;$i++){						
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
			case 'prog':
				//$blank = array(0,0,0,0,0,0,0,0,0,0,0,0); //MAXPTS length array
				//print_r($blank);
				//$setptArr = $blank;
				/*	PUT request to /prog/80302/sensor# – Update setpt for feed's sensor
					PUT request to /prog/80302 – Update all sensor for feed */			
				$sensor=$path[3];
				//echo $sensor;
				if (strlen($sensor)>0){//new setpoint for 1 sensor
					//echo($sensor." yo in case:prog of index.php");
					updateSetptArr($db, $path, $data);					
					//$setptArr[$sensor]=$data['setpt']+0;
					//$setptJ = "\n<".json_encode($setptArr).">\n";	
					echo $setptJ;			
				}else{//
					echo "in case:put case:prog /prog/80302/  setpoint array for MAXPTS sensors \n";
					$se = getSetptArr($db, $path);
					echo $se;
					zeroSetptArr($db, $path);			
					$se = getSetptArr($db, $path);
					echo $se;
				}
				break;	
		}
		echo("a put request has been put\n\n"); 
		break;	
	case 'delete':
	/*			
		DELETE request to /feed/80308 – Delete feed
		DELETE request to /prog/loc – Delete all progs for feed
		DELETE request to /prog/80308 – Delete all progs for feed */			
		echo("a delete request\n\n"); 
		break;	
}

function getRoomList($db, $feed){
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

function updateSetptArr($db, $path,$data){
	$setpt = $data['setpt'];
	$feed =$path[2];
	$sensor = $path[3];
	//echo $sensor;
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

function getSetptArr($db, $path){
	$feed =$path[2];
	try {
		$dbh  = new PDO("mysql:host=$db->host; dbname=$db->database",$db->user, $db->pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql  ='SELECT `setpt` FROM `setptArr` WHERE `feed`="'.$feed.'"'; 
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$se = $stmt->fetchAll(PDO::FETCH_COLUMN);
		//echo $sql;
		//print_r($se);
		$sse = json_encode($se);
		$sse = preg_replace( "/\"(\d+)\"/", '$1', $sse );//remove quotes from numbers
		$sse = "\n<".$sse.">\n";
		return $sse;
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