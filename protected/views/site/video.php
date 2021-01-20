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
    <div class="vid-container" id="<?php echo $vid->_id;?>">
      <video playsinline preload="metadata" onload="video.currentTime=sprungzeit" width="300" height="240" src="<?php echo Yii::app()->request->baseUrl .'/videos/uploads/'. $vid->eventId . '/'. $vid->file; ?>" Xautobuffer Xautoplay controls class="myVideo" poster="<?php echo $poster;?>">
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
          <a href="<?php echo Yii::app()->request->requestUri .'?remFav='. $vid->_id . '#'.$vid->_id;?>" style="display: block;float: right;clear: both;text-decoration: none;margin-left: 10px;">
            <i class="icon-star pull-left icon-2x muted icon-blue"></i>
          </a>

        <?php
        }
        else {
        ?>
          <a href="<?php echo Yii::app()->request->requestUri .'?addFav='. $vid->_id . '#'.$vid->_id; ?>" style="display: block;float: right;xclear: both;text-decoration: none;margin-left: 10px;">
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
          <!--  We'll hide this form and button if Modernizr detects that browser can't do direct html5 downloads -->
          <form class="single-download-form" action="/downloads" method="post" style="display: block;float: right;">
            <input type="hidden" name="VidDownloadForm[0]" value="<?php echo $vid->_id;?>">
            <label for="vid-<?php echo $vid->_id;?>" XXid="<?php echo $vid->_id;?>">
                <i class="icon-download-alt pull-left icon-2x muted <?php echo $boolShowGreenArrow;?>" style="display: block;float: right;xclear: both;text-decoration: none;"></i>
            </label>

            <input id="vid-<?php echo $vid->_id;?>" class="js-singleDownloadClick" type="submit" name="" value="Download" style="display: none;">
          </form>
          
          <!--  We'll show this link if Modernizr detects that browser can do direct html5 downloads -->
          <a download href="<?php echo Yii::app()->request->baseUrl .'/videos/uploads/'. $vid->eventId . '/'. $vid->file; ?>" data-vidid="<?php echo $vid->_id;?>" class="js-HTML5singleDownloadClick icon-download-alt pull-left icon-2x muted <?php echo $boolShowGreenArrow;?>" style="display: block;float: right;xclear: both;text-decoration: none;"></a>
      </div>
      
    </div>
  
  <?php
  }
  ?>

  <div class="bottom-spacer"></div>

</div>

<script type="text/javascript">

  var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/)

  if(isSafari) {
    /* Hide the app's default black play icon thumbs, so that they do not show under the built in browser play icons/poster */
    
    $.each( $('video'), function(i,v){
      
      var str = $(v).prop('poster')
      
      if ( str.search("videodefaultthumb.png") > 0)
        $(v).prop('poster',null);
    });
  }


  if(!isSafari) {
    /* Hide controls so that the browsers default play icon is hidden */          
    $('video').prop('controls',false);
    
    $('video').css('cursor','pointer'); 
    $(document).on('click', 'video', function(e) {
        e.preventDefault();

        this.controls=true;
        
        if (this.paused) {
            this.play();
        } else {
            this.pause();
        }
    });
  }

  // Handle the download click button (set its state to already downloaded on click, as opposed to waiting for a pg reload)
  $('.js-singleDownloadClick').css('cursor','pointer'); 
  $(document).on('click', '.js-singleDownloadClick', function(e) {     
    $(e.target).closest('form').find('i').addClass('icon-green')
  });

  if (Modernizr.adownload) {
    $('.single-download-form').hide();
    $('.js-HTML5singleDownloadClick').show();
  } else {
    $('.single-download-form').show();
    $('.js-HTML5singleDownloadClick').hide();
  }


  $('.js-HTML5singleDownloadClick').css('cursor','pointer'); 
  $(document).on('click', '.js-HTML5singleDownloadClick', function(e) {   

    var vidID = $(e.target).data('vidid');

    $.ajax({
        type: "POST",
        cache: false,
        url: "SetSingleDownloadCookie?videoID="+vidID,
    }).done(function() {
        $(e.target).removeClass('muted');
        $(e.target).addClass('icon-green');
    }).fail(function() { 
        console.log("post error");
    }).always(function() {
        console.log( "post complete" );
    });
  });
</script>