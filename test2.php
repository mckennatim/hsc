<?php
echo header("Content-type: text/plain");
$progs='{"current":{"feed":"80302","name":"current","ckts":[[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],null,[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],[[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],null,[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[{"time":"01:30","setpt":"57"},{"time":"10:30","setpt":"57"},{"time":"10:30","setpt":"67"},{"time":"13:30","setpt":"57"}],[]],null,null,null,null,[[{"time":"10:30","setpt":"157"},{"time":"10:30","setpt":"157"}],null,null,null,null,null,[{"time":"10:30","setpt":"157"},{"time":"10:30","setpt":"157"}]]]}}';
$progsD=json_decode($progs);
print_r($progsD);
?>