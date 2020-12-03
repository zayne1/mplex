<style type="text/css">
        .menu-top { display: block; }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>
    <span class="visible-phone">For downloading large numbers of files, please visit www.metroplexstream.com using a PC or Laptop.</span>

    <div class="vid-dl-container">
        <div style="width:100%;height:24px;">
            <div id="select-all-vid">Select all</div>
        </div>
        
        <form id="downloads-form" action="/downloads" method="post">
            <?php 
            $count=1;
            $jsCount=0;
            foreach ($vidList as $vid) { 
            ?>

                <div class="vid-dl-item" id="<?php echo $vid->_id;?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/videothumbs/videodefaultthumb.png">
                    <div class="vid-info-block">
                        <div class="vid-info-block-name marquee">
                            <div class="trackXXX">
                                <?php echo $vid->label; ?>
                            </div>
                        </div>
                        <span><?php echo $vid->sizeLabel; ?></span>
                        <span>&nbsp; &nbsp; &nbsp;<?php echo $vid->length; ?></span>
                    </div>
                    <input class="vid-dl-item-checkbox" type="checkbox" name="<?php echo "VidDownloadForm[video" .$count. "]"; ?>" value="<?php echo $vid->_id;?>">
                </div>

                <script type="text/javascript">     
                //***** Start Scrolling & marquee adding code *******//
                    var scrollEventHandler<?php echo $jsCount;?> = function() {
                        if(isScrolledIntoView( $('.vid-info-block').get(<?php echo $jsCount;?>) )) {
                            setTimeout(function(){ 
                                $('#<?php echo $vid->_id;?>').closest('.vid-dl-item').find('.trackXXX').addClass('track');
                            }, 1500);

                            unbindScrollEventHandler(<?php echo $jsCount;?>);
                        }
                    }

                    $(window).scroll(scrollEventHandler<?php echo $jsCount;?>);

                //***** End Scrolling & marquee adding code *******//
                </script>
            <?php
            $count++;
            $jsCount++;
            }
            ?>
            <div class="download-submit-container">
                <input type="submit" name="" value="Download" class="download-submit">
            </div>
        </form>
    </div>

  <!-- <a href="<?php //echo Yii::app()->createUrl('multidownloadtest'); ?>">Multi download proof of concept (Click link to Download all currently set favourites)</a></li>-->
    
    
    <script type="text/javascript">

        $('#select-all-vid').css('cursor','pointer'); 
        $(document).on('click', '#select-all-vid', function() {
            if( $("input.vid-dl-item-checkbox").is(':checked') === false){ 
                $('input.vid-dl-item-checkbox').prop('checked',true);
            } else if( $("input.vid-dl-item-checkbox").is(':checked') === true){
                $('input.vid-dl-item-checkbox').prop('checked',false);
            }
        });
    </script>
    
    <script type="text/javascript">        
        /* Code to handle the front-end zip creation dialog */

        $('.download-submit-container').css('cursor','pointer'); 
        $(document).on('click', '.download-submit-container', function() {     
            $.ajax({
                type: "POST",
                cache: false,
                url: "SetZippingStatus?status=1", // set status to 1 once download starts
                async: false,
            }).done(function() {
                $('#prep-download-container').show();
                intervalHandle = setInterval(function(){ downloadZipPoller(); }, 1000);    // check status every second
            }).fail(function() { 
                console.log("post error");
            }).always(function() {
                console.log( "post complete" );
            });
        });

        function downloadZipPoller(){
            $.ajax({ 
                type: "GET",
                cache: false,
                url: "GetZippingStatus", 
                timeout: 1500,
            }).done(function( result ) {
                if (result === 0) { // when done with zipping (status is set yo 0/false in backend)
                    $('#prep-download-container').hide();
                    clearInterval(intervalHandle);
                }
            }).fail(function() { 
                console.log("ajax error");
            }).always(function() {
                console.log( "complete" );
            });
        }


        //***** Start Scrolling & marquee adding code *******//
                
        window.scrollTo(0, 1); // Do an initial 1px scroll down to 'activate' the initial items, as they are viewable on pg load

        function unbindScrollEventHandler(num) {
            // $('#downloads-form').unbind('scroll', window['scrollEventHandler'+num]);
            $(document).unbind('scroll', window['scrollEventHandler'+num]);
        }

        function isScrolledIntoView(el) {
            var elemTop = el.getBoundingClientRect().top;
            var elemBottom = el.getBoundingClientRect().bottom;

            var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
            return isVisible;
        }

        //***** End Scrolling & marquee adding code *******//

    </script>
    
</div>

<div class="loading" id="prep-download-container">
    <div id="prep-download">
        <i class="icon-spinner icon-spin"></i>
        Preparing your download
    </div>
</div>