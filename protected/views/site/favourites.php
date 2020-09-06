<style type="text/css">
        .menu-top { display: block; }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>
  <?php 
  foreach ($vidList as $vid) { 
  ?>
      <div class="vid-countainer" style="width: 340px;height: 280px;float: left;">
        <video onload="video.currentTime=sprungzeit" width="320" height="240" src="<?php echo Yii::app()->request->baseUrl .'/vid/'. $vid->file; ?>" Xautobuffer Xautoplay controls class="myVideo" style="float: left;margin-right: 10px;">
          <div class="video-fallback">
           <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
          </div>
        </video>

        <?php if ($vid->fav==1) {
        ?>
          <a href="<?php echo Yii::app()->request->baseUrl .'/favourites?remFav='. $vid->_id; ?>" style="display: block;float: right;clear: both;text-decoration: none;">
            <i class="icon-star pull-left icon-3x muted icon-green"></i>
          </a>

        <?php
        }
        ?>
        
      </div>
  
  <?php
  }
  ?>
  
</div>