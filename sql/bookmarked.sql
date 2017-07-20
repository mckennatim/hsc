SELECT  `circuit` ,  `temp` , ROUND( temp *9 / ( 16 *5 ) +32 ) AS Ftemp,  `relay` , ROUND( setpt *9 / ( 8 *5 ) +32 ) AS Fset,  `setpt` ,  `time` , FROM_UNIXTIME( TIME ) 
FROM  `feed` 
WHERE  `circuit` =  "ckt3"
ORDER BY circuit, TIME DESC 
LIMIT 0 , 30

feed_w_ckt:
SELECT `circuit`,`temp`, ROUND(temp*9/(16*5)+32,1) AS Ftemp,`relay`,ROUND( setpt *9 / ( 8 *5 ) +32,1) AS Fset,`setpt`,`time`, from_unixtime(time) FROM `feed` WHERE `circuit`='/*[VARIABLE]*/' ORDER BY time DESC LIMIT 60,30

SELECT `circuit`,`temp`, ROUND(temp*9/(16*5)+32,1) AS Ftemp,`relay`,ROUND( setpt *9 / ( 8 *5 ) +32,1) AS Fset,`setpt`,`time`, from_unixtime(time) FROM `feed` ORDER BY time DESC LIMIT 60,30

SELECT `circuit`,`temp`, ROUND(temp*9/(16*5)+32,1) AS Ftemp,`relay`,ROUND( setpt *9 / ( 8 *5 ) +32,1) AS Fset,`setpt`,`time`, from_unixtime(time) FROM `feed` WHERE `circuit`='/*[VARIABLE]*/' ORDER BY time DESC LIMIT 60,30

SELECT t1.circuit,`temp`, ROUND(temp*9/(16*5)+32,1) AS Ftemp,`relay`,ROUND( setpt *9 / ( 8 *5 ) +32,1) AS Fset,`setpt`,`time`, from_unixtime(time) , room, defsetpt FROM `feed` t1
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

SELECT * 
FROM  `progs` 
ORDER BY ckt, 
day, clock
LIMIT 0 , 30

SELECT id, room, rname, circuit, SUBSTRING( circuit, 4 ) AS rckt
FROM  `rooms` Where feed =80302
LIMIT 0 , 30

SELECT * 
FROM  `progs` 
INNER JOIN (
	SELECT rname, circuit, SUBSTRING( circuit, 4 ) AS rckt
	FROM  `rooms`)AS rm
ON progs.ckt=rm.rckt
ORDER BY ckt, 
day, clock
