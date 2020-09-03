<style type="text/css">
        .menu-top { display: block; }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>


<script type="text/javascript">
//Sprungzeit ausrechnen
var d = new Date(); //Datum erzeugen
var curr_hour = d.getHours();
var curr_hour_sec = curr_hour * 3600;
var curr_min = d.getMinutes();
var curr_min_sec = curr_min * 60;
var curr_sec = d.getSeconds();
var curr_sec_all = curr_hour_sec + curr_min_sec + curr_sec ; //Wie viele Sekunden sind seit 0:00 vergangen
var curr_prozent = curr_sec_all / 19855; //Wie viel Prozent sind an Sekunden im Vergleich zu 19855s (=Videol�nge 5:30:55) vergangen (19855s = 100% ; 86400 (24h) = 435%)
//Wenn die vergangenen Sekunden gr��er sind als 100%, wird spraktisch vorne die Hunderterstelle weggenommen; aus 180% wird 80% bzw. aus 1,80 wird 0,80
if (curr_prozent>1)
    {
    var curr_prozent_final = curr_prozent - 1;
    }
if (curr_prozent>2)
    {
    var curr_prozent_final = curr_prozent - 2;
    }
if (curr_prozent>3)
    {
    var curr_prozent_final = curr_prozent - 3;
    }
if (curr_prozent>4)
    {
    var curr_prozent_final = curr_prozent - 4;
    }   
 
var sprungzeit = 19855 * curr_prozent_final; //finale Sprungzeit ausrechnen.
    
document.write(curr_hour + ":" + curr_min + ":" 
+ curr_sec + ":" + curr_msec + " hahaha " + curr_sec_all + " " + curr_prozent + " " + curr_prozent_final);
</script>
    
    <?php if($username=='admin') { ?>
      <video onload="video.currentTime=sprungzeit" width="320" height="240" src="<?php echo Yii::app()->request->baseUrl; ?>/vid/Charles1.mp4" Xautobuffer Xautoplay controls class="myVideo" style="float: left;margin-right: 10px;">
 
               <div class="video-fallback">
 
                    <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
             </div>
 
      </video>
	<?php } ?>

	<?php if($username=='demo') { ?>
      <video onload="video.currentTime=sprungzeit" width="320" height="240" src="<?php echo Yii::app()->request->baseUrl; ?>/vid/Charles2.mp4" Xautobuffer Xautoplay controls class="myVideo" style="float: left;margin-right: 10px;>
 
               <div class="video-fallback">
 
                    <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
             </div>
 
      </video>
  	<?php } ?>
        
        <script type="text/javascript">
//var video2 = document.getElementsById("makingof").innerHTML[0];
//var video = document.getElementsByTagName("video")[0];
var video = document.getElementsByClassName("myVideo");
</script>
    
</div>