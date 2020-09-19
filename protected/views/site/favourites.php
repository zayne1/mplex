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
      <div class="vid-container">
        <video onload="video.currentTime=sprungzeit" width="300" height="240" src="<?php echo Yii::app()->request->baseUrl .'/vid/'. $vid->file; ?>" Xautobuffer Xautoplay controls class="myVideo" style="float: left;margin-right: 10px;">
          <div class="video-fallback">
           <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
          </div>
        </video>
        <div class="vid-info-txt">
          <?php echo $vid->label; ?>
          <br>
          <span><?php echo $vid->size; ?></span>
        </div>
        <div class="vid-info-footer">

          <?php if ($vid->fav==1) {
          ?>
            <a href="<?php echo Yii::app()->request->baseUrl .'/favourites?remFav='. $vid->_id; ?>" style="display: block;float: right;clear: both;text-decoration: none;">
              <i class="icon-star pull-left icon-2x muted icon-blue"></i>
            </a>

          <?php
          }
          ?>
          <?php if ($vid->downloaded==1) {
          ?>
            <i class="icon-download-alt pull-left icon-2x muted icon-green" style="display: block;float: right;xclear: both;text-decoration: none;"></i>
          <?php
          }
          ?>
        </div>
        
      </div>
  
  <?php
  }
  ?>

  <div class="bottom-spacer">xx</div>
  
</div>