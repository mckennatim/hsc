<?php
include  '/usr/local/lib/tm/db.php';
include '/var/www/hsc/Tbl.php';

class TblTest extends \PHPUnit_Framework_TestCase
{
	public function testDoesDbContainDbname()
	{
		$dbn='hsc';
		$dodb = new db($dbn);	
		$dbnn = $dodb->database;
		$this->assertEquals($dbn, $dbnn);
	}
	public function testLastInsertIdIsReturned()
	{
		$dbo = new db('hsc');
		$ta = new Tbl("feed", $dbo);
		$insarr=array(
			'afeed'=>'80332', 
			'circuit'=>'ckt5',
			"temp"=>237,
			"relay"=>0,
			"setpt"=>155,
			"time"=>1388111111
		);
		$ta->setInsArr($insarr);
		$ta->pdo_insert();
		$this->assertFalse($ta->lastInsertId==0);
	}
	public function testInsarrayIsSet()
	{
		$dbo = new db('hsc');
		$ta = new Tbl("feed", $dbo);
		$insarr=array(
			'afeed'=>'80332', 
			'circuit'=>'ckt5',
			"temp"=>237,
			"relay"=>0,
			"setpt"=>155,
			"time"=>1388111111
		);
		$ta->setInsArr($insarr);
		$this->assertEquals($insarr['afeed'],$ta->insarr['afeed']);
	}
	public function testInsWcolonIsSet()
	{
		$dbo = new db('hsc');
		$ta = new Tbl("feed", $dbo);
		$insarr=array(
			'afeed'=>'80332', 
			'circuit'=>'ckt5',
			"temp"=>237,
			"relay"=>0,
			"setpt"=>155,
			"time"=>1388111111
		);
		$ta->setInsArr($insarr);
		$this->assertEquals($insarr['afeed'],$ta->insWcolon[':afeed']);
	}	
}
?>