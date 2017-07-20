# hsc

deployed on parleyelvale.com /var/www/hsc. 

if 502 error try `service php5-fpm restart && service nginx restart` (in`var/log/nginx/error.log` there were `[error] 4865#0: *53159 connect() to unix:/var/run/php5-fpm.sock failed (111: Connection refused)` )

