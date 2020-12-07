<style type="text/css">
        .menu-top { display: block; }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>
  <?php 
  $prevVidId = '';
  foreach ($vidList as $vid) { 
    if ( $favVidList && in_array($vid->_id, $favVidList) ) { // if vid is a fav (if it's in fav cookie)
    ?>
        <div class="vid-container" id="<?php echo $vid->_id;?>">
          <video onload="video.currentTime=sprungzeit" width="300" height="240" src="<?php echo Yii::app()->request->baseUrl .'/videos/uploads/'. $vid->eventId . '/'. $vid->file; ?>" Xautobuffer Xautoplay controls class="myVideo">
            <div class="video-fallback">
             <br>Sie benoetigen einen Browser, der HTML5 unterstuetzt.
            </div>
          </video>
          <div class="vid-info-txt">
            <?php echo $vid->label; ?>
            <br>
            <span><?php echo $vid->sizeLabel; ?></span>
          </div>
          <div class="vid-info-footer">

            <?php if ( $favVidList && in_array($vid->_id, $favVidList) ) { // if fav (in download cookie)
            ?>
              <a href="<?php echo Yii::app()->request->baseUrl .'/favorites?remFav='. $vid->_id . '#'.$prevVidId; ?>" style="display: block;float: right;clear: both;text-decoration: none;">
                <i class="icon-star pull-left icon-2x muted icon-blue"></i>
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
    $prevVidId = $vid->_id;
    }
  }
?>

  <div class="bottom-spacer">&nbsp;&nbsp;</div>
  
</div>

<script type="text/javascript">

  // Handle the download click button (set its state to already downloaded on click, as opposed to waiting for a pg reload)
  $('.js-singleDownloadClick').css('cursor','pointer'); 
  $(document).on('click', '.js-singleDownloadClick', function(e) {     
    $(e.target).closest('form').find('i').addClass('icon-green')
  });
</script>