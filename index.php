<?php
include 'rest.php';
include  '/usr/local/lib/tm/db.php';

$req = RestUtils::processRequest();
$path =$req->getPathArr();
$db = new db();
$db->setDb($path[0]);

//just a bunch of not really needed stuff
echo $req->getMethod()." frod\n\n";
print_r($req->getHttpAccept());
print_r($req->getJson());
print_r($req->getHttpHeaders());
print_r($req->getPathArr());
print_r($req->getData()); 
echo $json."\n\n";
echo $req->getTimeStamp() ."\n"; 
echo date('l jS \of F Y h:i:s A', $req->getTimeStamp() - 3600*5). "\n\n";


switch($req->getMethod())
{
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
		echo("a get request");
		break;
	case 'post':
		/*
		POST request to /feed – Create a new feed
		POST request to /prog/loc -create a new prog for location
		POST request to /prog/ -create a new location	*/
		echo("a post request"); 
		break;
	case 'put':
	/*PUT request to /feed/80308 – Update feed with additional data */	
	$type  = $path[1];
	if (!strcmp($type, 'feed')){ //strcmp returns 0 when equal
		$feed=$path[2];	
		$data=$req->getData();
		for($i=0;$i<sizeOf($data['data']['temp']);$i++){
			
			$temp= $data['data']['temp'][$i];
			$relay = $data['data']['relay'][$i];
			$setpt = $data['data']['setpt'][$i];
			$circuit = "ckt".$i;
			//$insarr = array();
			$insarr=array(
				'feed'=>$feed, 
				'circuit'=>$circuit,
				"temp"=>$temp,
				"relay"=>$relay,
				"setpt"=>$setpt,
				"time"=>$req->getTimeStamp()
				);
			//print_r($insarr);
			$db->setTable($type);
			$db->setInsArr($insarr);	
			print_r($insarr);
			$db->pdo_insert();
		}
		//$bit2 = $data['data'];
	}	
	/*	PUT request to /prog/80302/sensor – Update progs for feed's sensor
		PUT request to /prog/80302 – Update all progs for feed
		PUT request to /prog/loc – Update progs for all locations
		PUT request to /prog/loc/peri_study – Update progs for location	  */
		echo("a put request\n\n"); 
		break;	
	case 'delete':
	/*			
		DELETE request to /feed/80308 – Delete feed
		DELETE request to /prog/loc – Delete all progs for feed
		DELETE request to /prog/80308 – Delete all progs for feed */			
		echo("a delete request\n\n"); 
		break;	
}




?>