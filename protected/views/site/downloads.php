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
            foreach ($vidList as $vid) { 
            ?>

                <div class="vid-dl-item">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/videothumbs/videodefaultthumb.png">
                    <div class="vid-info-block">
                        <?php echo $vid->label; ?>
                        <br>
                        <span><?php echo $vid->size; ?></span>
                        <span>&nbsp; &nbsp; &nbsp;<?php echo $vid->length; ?></span>
                    </div>
                    <input class="vid-dl-item-checkbox" type="checkbox" name="<?php echo "VidDownloadForm[video" .$count. "]"; ?>" value="<?php echo $vid->_id;?>">
                </div>
            <?php
            $count++;
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
            $.post('GetZippingStatus?status=1', function() { // set status to 1 once download starts
                $('#prep-download-container').show();
                intervalHandle = setInterval(function(){ downloadZipPoller(); }, 1000);    // check status every second
            });
        });

        function downloadZipPoller(){
            $.ajax({ 
                type: "GET",
                cache: false,
                url: "GetZippingStatus",                
            }).done(function( result ) {
                if (result === false) { // when done with zipping (status is set yo 0/false in backend)
                    $('#prep-download-container').hide();
                    clearInterval(intervalHandle);
                }
            }).fail(function() { 
                alert( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        }

    </script>
    
</div>

<div class="loading" id="prep-download-container">
    <div id="prep-download">
        <i class="icon-spinner icon-spin"></i>
        Preparing your download
    </div>
</div>