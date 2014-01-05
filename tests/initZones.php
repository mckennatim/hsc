<?php
include  '/usr/local/lib/tm/db.php';
include '/var/www/hsc/Tbl.php';
$zonesJson = '[{"id":"183720","feed":"80302","room":"livingroom","rname":"Livingroom","circuit":"ckt0","defsetpt":"152"},{"id":"183721","feed":"80302","room":"music","rname":"Music","circuit":"ckt1","defsetpt":"120"},{"id":"183722","feed":"80302","room":"floor2","rname":"Kid`s Suite","circuit":"ckt2","defsetpt":"140"},{"id":"183723","feed":"80302","room":"floor3","rname":"Master Suite","circuit":"ckt6","defsetpt":"138"},{"id":"183724","feed":"80302","room":"peris","rname":"Peri`s ","circuit":"ckt4","defsetpt":"115"},{"id":"183725","feed":"80302","room":"marthas","rname":"Martha`s","circuit":"ckt5","defsetpt":"115"},{"id":"183726","feed":"80302","room":"TVroom","rname":"TV room","circuit":"ckt3","defsetpt":"135"}]';
$zonesArr=json_decode($zonesJson);
foreach ($zonesArr as $insarr) {
	$dbo = new db("hsc");
	$tablename='rooms';
	$tb = new Tbl($tablename, $dbo);
	$tb->setInsArr($insarr);
	$tb->pdo_insert();
}
?>