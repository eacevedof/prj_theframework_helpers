<!--elem_analytics 1.0.0-->
<?php
$sRemoteIp = $_SERVER["REMOTE_ADDR"];
$arNoGoogle = [
    "83.56.121.212", //hme
    "217.116.5.17",  //job
];
if(!in_array($sRemoteIp,$arNoGoogle)):
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-98226675-1', 'auto');
  ga('send', 'pageview');

</script>
<?php
endif;
?>
<!--elem_analytics-->