-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2013 at 07:00 PM
-- Server version: 5.1.67
-- PHP Version: 5.3.2-1ubuntu4.18

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `hsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `afeed` varchar(7) NOT NULL,
  `circuit` varchar(5) NOT NULL,
  `temp` int(5) NOT NULL,
  `relay` int(1) NOT NULL,
  `setpt` int(5) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`feed`,`relay`,`time`),
  KEY `circuit` (`circuit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183720 ;

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `feed` varchar(7) NOT NULL,
  `room` varchar(12) NOT NULL,  	
  `circuit` varchar(5) NOT NULL,
  `setpt` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feed` (`feed`),
  KEY `fid` (`feed`,`circuit`),
  KEY `circuit` (`circuit`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=183720 ;

SELECT * FROM `feed` 
LEFT JOIN rooms USING(circuit) 
WHERE room='livingroom' 
ORDER BY `time` DESC LIMIT 1

--example of query to get last unique records
--inner query gets maxdatestamp for every circuit of every feed

SELECT t1.*, room, defsetpt FROM `feed` t1
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
WHERE t1.afeed = "80302"

--inner query gets maxdatestamp for every circuit of every feed
SELECT
     feed  
     , circuit
     , MAX(time) AS MAXDATESTAMP
   FROM feed
   GROUP BY feed, circuit
   
SELECT t1.* FROM `feed` t1
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
AND (t1.time = t2.MAXDATESTAMP
WHERE t1.afeed = "80302"   

SELECT * FROM `rooms` 
LEFT JOIN feed USING(circuit) 
	
--select all the rooms from roms and the latest temperature read for that room or null if none--	
SELECT * FROM `rooms` 
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
WHERE t1.afeed = "80302"	) AS t3 USING(circuit) 
	
--select the last record of each circuit--

SELECT t1.*, substring(t1.circuit,4)+0 as orde FROM `feed` t1
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
WHERE t1.afeed = "80302"		
ORDER BY orde

CREATE TABLE `setptArr` (
`id` int(12) NOT NULL AUTO_INCREMENT,
`feed` int(8) NOT NULL,
`sensor` int(2) NOT NULL, 
`setpt` int(5) NOT NULL,
  	PRIMARY KEY (`id`),
  		KEY (`feed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100;

INSERT INTO setptArr (feed, sensor, setpt)
	VALUES 
	(80302,0,10),
	(80302,1,10),	
	(80302,2,10),	
	(80302,3,10),	
	(80302,4,10),	
	(80302,5,10),	
	(80302,6,10),	
	(80302,7,10),	
	(80302,8,10),	
	(80302,9,10),	
	(80302,10,10),	
	(80302,11,10);	

UPDATE `setptArr`  SET `setpt` = 0  WHERE `feed`=80302 
	
UPDATE `setptArr`  SET `setpt` = 167  WHERE `feed`=80302 AND `sensor`=4
	
CREATE TABLE IF NOT EXISTS `holds` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `feed` varchar(7) NOT NULL,
  `ckt` varchar(5) NOT NULL,
  `setpt` int(5) NOT NULL,
  `start` int(10) NOT NULL,
  `finish` int(10) NOT NULL,  	
  PRIMARY KEY (`id`),
  KEY `feed` (`feed`),
  KEY `fc` (`feed`,`ckt`),
  KEY `fcs` (`feed`,`ckt`, `start`),  	
  KEY `start` (`start`),
  KEY `finish` (`finish`)  	
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=300 ;

CREATE TABLE IF NOT EXISTS `progs` (
	`id` int(12) NOT NULL AUTO_INCREMENT,
	`feed` varchar(7) NOT NULL,
	`ver`varchar(12) NOT NULL, 
	`day` varchar(7) NOT NULL, 	
	`ckt` varchar(5) NOT NULL,
	`when` int(10) NOT NULL,
	`setpt` int(5) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `feed` (`feed`),
	KEY `when` (`when`),
	KEY `fvw` (`feed`,`ver`,`when`),  	
	KEY `ckt` (`ckt`),
	KEY `fvc` (`feed`,`ver`,`ckt`)  	
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=500 ;

DELETE FROM `progs` WHERE `feed`="80302" AND `ver` = "current" 

SELECT ckt, setpt, clock FROM progs WHERE feed = "80302" AND day=4 AND clock<"12:15:00" ORDER BY ckt, clock DESC


SELECT ckt, setpt, clock FROM progs t1
INNER JOIN
  SELECT ckt, setpt, clock FROM progs 
  WHERE feed = "80302" AND day=4 AND clock<"12:15:00" 
  ORDER BY ckt, clock DESC as t2
ON t1.ckt=t2.ckt AND t1.setpt=t2.setpt AND t1.clock=t2.clock

--select max that meets condition for each group



--

SELECT ckt, setpt, clock FROM progs t1
INNER JOIN
  SELECT ckt, setpt, clock FROM progs 
  WHERE feed = "80302" AND day=4 AND clock<"12:15:00" t2
ON t1.ckt=t2.ckt AND t1.setpt=t2.setpt 
GROUP BY t2.ckt
WHERE t1.clock=MAX(t2.clock)


    ckt setpt clock
    0 69  06:06:00
    1 67  10:30:00
    1 57  01:30:00
    2 69  06:06:00
    3 69  06:06:00
    4 69  06:06:00
    4 62  00:30:00
    5 57  10:30:00
    5 67  10:30:00
    5 57  01:30:00
    6 57  10:30:00
    6 67  10:30:00
    6 57  01:30:00

SELECT p.ckt, p.setpt, p.clock, p.feed
FROM progs p
JOIN (
  SELECT MAX( clock ) maxClock, ckt
  FROM progs
  WHERE feed =  "80302"
  AND DAY =4
  AND clock <  "12:15:00"
  GROUP BY ckt
)p2 ON p.ckt = p2.ckt
AND p.clock = p2.maxclock
GROUP BY p.ckt
LIMIT 0 , 30

SELECT p.ckt, p.setpt, p.clock 
FROM progs p
    JOIN (
        SELECT MAX(clock) maxClock, ckt
        FROM progs 
        WHERE feed = "80302" 
            AND day=4 
            AND clock<"12:15:00" 
        GROUP BY ckt
    ) p2 on p.ckt = p2.ckt AND p.clock = p2.maxclock
ORDER BY p.ckt, p.clock DESC

I wish I knew how to take a problem and construct joins to answer it. From your sql I can deconstruct that here the idea is to just find the max time < 12:30 and then add in the setpt by joining it to the results of the inner query. Thanks


SELECT ckt, setpt , MAX( clock ) 
FROM progs
WHERE feed =  "80302"
AND DAY =4
AND clock <  "12:15:00"
GROUP BY ckt
ORDER BY ckt, clock DESC 

