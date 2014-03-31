SELECT  `circuit` ,  `temp` , ROUND( temp *9 / ( 16 *5 ) +32 ) AS Ftemp,  `relay` , ROUND( setpt *9 / ( 8 *5 ) +32 ) AS Fset,  `setpt` ,  `time` , FROM_UNIXTIME( TIME ) 
FROM  `feed` 
WHERE  `circuit` =  "ckt3"
ORDER BY circuit, TIME DESC 
LIMIT 0 , 30

feed_w_ckt:
SELECT `circuit`,`temp`, ROUND(temp*9/(16*5)+32,1) AS Ftemp,`relay`,ROUND( setpt *9 / ( 8 *5 ) +32,1) AS Fset,`setpt`,`time`, from_unixtime(time) FROM `feed` WHERE `circuit`=/*[VARIABLE]*/  ORDER BY circuit, time DESC LIMIT 60,30