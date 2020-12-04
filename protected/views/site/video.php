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
    $poster = '';
    if ($vid->thumb)
      $poster = Yii::app()->request->baseUrl .'/images/videothumbs/'. $vid->thumb;

  ?>
    <div class="vid-container">
      <video onload="video.currentTime=sprungzeit" Xwidth="300" Xheight="240" src="<?php echo Yii::app()->request->baseUrl .'/videos/uploads/'. $vid->eventId . '/'. $vid->file; ?>" Xautobuffer Xautoplay controls class="myVideo" poster="<?php echo $poster;?>">
        <div class="video-fallback">
          <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
        </div>
      </video>
      <div class="vid-info-txt">
        <?php echo $vid->label; ?>
        <br>
        <span><?php echo $vid->sizeLabel; ?></span>
        <span>&nbsp; &nbsp; &nbsp;<?php echo $vid->length; ?></span>

      </div>
      <div class="vid-info-footer">

        <?php if ( $favVidList && in_array($vid->_id, $favVidList) ) { // if downloaded (in download cookie)
        ?>
          <a href="<?php echo Yii::app()->request->requestUri .'?remFav='. $vid->_id; ?>" style="display: block;float: right;clear: both;text-decoration: none;margin-left: 10px;">
            <i class="icon-star pull-left icon-2x muted icon-blue"></i>
          </a>

        <?php
        }
        else {
        ?>
          <a href="<?php echo Yii::app()->request->requestUri .'?addFav='. $vid->_id; ?>" style="display: block;float: right;xclear: both;text-decoration: none;margin-left: 10px;">
              <i class="icon-star pull-left icon-2x muted "></i>
          </a>
        <?php
        }
        ?>
        
        <?php 
        $boolShowGreenArrow = '';
        if ( $vidDownloadedList && in_array($vid->_id, $vidDownloadedList) ) { // if downloaded (in download cookie)
            $boolShowGreenArrow = 'icon-green';
        }
        ?>
          
          <form id="single-download-form" action="/downloads" method="post" style="display: block;float: right;">
            <input type="hidden" name="VidDownloadForm[0]" value="<?php echo $vid->_id;?>">
            <label for="vid-<?php echo $vid->_id;?>" XXid="<?php echo $vid->_id;?>">
                <i class="icon-download-alt pull-left icon-2x muted <?php echo $boolShowGreenArrow;?>" style="display: block;float: right;xclear: both;text-decoration: none;"></i>
            </label>

            <input id="vid-<?php echo $vid->_id;?>" class="js-singleDownloadClick" type="submit" name="" value="Download" style="display: none;">
          </form>
      </div>
      
    </div>
  
  <?php
  }
  ?>

  <div class="bottom-spacer"></div>

  <!--<a href="<?php //echo Yii::app()->createUrl('multidownloadtest'); ?>">Multi download proof of concept (Click link to Download all currently set favourites)</a></li> -->
    
    <script type="text/javascript">
        
        // if( $.browser.mozilla) {
          
          $('video').prop('controls',false);

          $(document).on('click', 'video', function() {
              this.controls=true;
              this.play();
          });
        // }

        // Handle the download click button (set its state to already downloaded on click, as opposed to waiting for a pg reload)
        $('.js-singleDownloadClick').css('cursor','pointer'); 
        $(document).on('click', '.js-singleDownloadClick', function(e) {     
          $(e.target).closest('form').find('i').addClass('icon-green')
        });
    </script>
</div>