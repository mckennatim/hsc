<?php
include  '/usr/local/lib/tm/db.php';
include '/var/www/hsc/Tbl.php';
echo header("Content-type: text/plain");

$boho='{"0":{"start":1387383414,"finish":1387386114,"setpt":68,"feed":80302,"ckt":"0"},"1":{"start":1387379784,"finish":1389971784,"setpt":"58","feed":80302,"ckt":"4"},"2":{"start":1387380454,"finish":1389972454,"setpt":"60","feed":80302,"ckt":"2"},"3":{"start":1387391334,"finish":1389983334,"setpt":"64","feed":80302,"ckt":"3"},"4":{"start":1387481544,"finish":1387485144,"setpt":68,"feed":80302,"ckt":"4"},"5":{"start":1387379404,"finish":1389971404,"setpt":"63"},"6":{"start":1387390667,"finish":1389982667,"setpt":"61","feed":80302,"ckt":"6"},"7":{"start":1387379404,"finish":1389971404,"setpt":"63"},"8":{"start":1387379404,"finish":1389971404,"setpt":"63"},"9":{"start":1387379404,"finish":1389971404,"setpt":"63"},"10":{"start":1387379404,"finish":1389971404,"setpt":"63"},"11":{"start":1387379404,"finish":1389971404,"setpt":"63"}}';
$zonesArr=json_decode($boho);
foreach ($zonesArr as $insarr) {
	$dbo = new db("hsc");
	$tablename='holds';
	//print_r($insarr);	
	$tb = new Tbl($tablename, $dbo);
	$tb->setInsArr($insarr);
	$tb->pdo_insert();
}
?>