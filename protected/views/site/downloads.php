<style type="text/css">
        .menu-top { display: block; }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>

    <div class="vid-dl-container">
        <form id="downloads-form" action="/downloads" method="post">
            <?php 
            $count=1;
            foreach ($vidList as $vid) { 
            ?>

                <div class="vid-dl-item">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/videothumb.png">
                    <div class="vid-info-block"><?php echo $vid->file; ?></div>
                    <input class="vid-dl-item-checkbox" type="checkbox" name="<?php echo "VidDownloadForm[video" .$count. "]"; ?>" value="<?php echo $vid->_id;?>">
                </div>
            <?php
            $count++;
            }
            ?>
            <input type="submit" name="" value="Download" class="sign-submit">
        </form>
    </div>

  <!-- <a href="<?php //echo Yii::app()->createUrl('multidownloadtest'); ?>">Multi download proof of concept (Click link to Download all currently set favourites)</a></li>-->
    
    

    
</div>