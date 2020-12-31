<?php /* @var $this Controller */ 

$backend = false;
if ( isset(Yii::app()->controller->module->is_backend) && (Yii::app()->controller->module->is_backend==true))
    $backend = true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="shortcut icon" type="image/jpg" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <meta name="viewport" content="width=device-width, minimal-ui">
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <?php
    if ($backend){
    ?>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <?php
    }
    ?>

	<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile('/css/bootstrap.css');
    $cs->registerCssFile('/css/bootstrap-responsive.min.css');
    $cs->registerCssFile('/css/fa/css/font-awesome.min.css');
    $cs->registerCssFile('/css/animate.min.css');
    $cs->registerCssFile('/css/metroplex.css');
    
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('multifile', CClientScript::POS_END);

    ?>

	<style type="text/css">
        .menu-top
        {
            display: none;
        }
        .icon-green {
            color:#42B142;
        }
        .icon-blue {
            color:#0073c3;
        }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
</head>


<?php 
    $bodyIdTag = '';
    
    if (isset(Yii::app()->controller->module) )
        $bodyIdTag.=Yii::app()->controller->module->getName() .'-';
    
    $bodyIdTag.=Yii::app()->controller->getId();
    $bodyIdTag.='-'.Yii::app()->controller->getAction()->getId();
?>

<body id="<?php echo $bodyIdTag;?>">
    <div class="header">
        <hr/>
        <!-- <a href="index.php"> -->
        
        <?php 
        if ( $backend ) { ?>
        <a href="<?php echo Yii::app()->createUrl('backend/index'); ?>">
            <img class="home-icon-backend" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-home-backend.png">
        </a>
        <?php 
        } else { ?>
        <a href="<?php echo Yii::app()->createUrl(' '); ?>">
            <img class="home-icon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-home-frontend.png">
        </a>
        <?php 
        } ?>
        <?php
        if ( $backend ) {
        ?>
            <a href="<?php echo Yii::app()->createUrl('backend/index'); ?>" class="dash-header">Dashboard</div>
            <a href="<?php echo Yii::app()->createUrl('backend/organization/create'); ?>" class="backend btn-new-org">New Org</a>
            <a href="<?php echo Yii::app()->createUrl('backend/event/create'); ?>" class="backend btn-new-event">New Event</a>
            <a href="<?php echo Yii::app()->createUrl('backend/user/update/id/'.Yii::app()->user->userid); ?>" class="backend btn-login-update">Update log-in details</a>
        <?php
        }
        ?>
        
        <?php 
        if ( $backend ) { ?>
        <img class="logo-user-profile" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-m.png">
        <?php 
        } else { ?>
        <img class="logo-txt" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-txt.png">
        <?php
        } ?>

    </div>
    <div class="menu-top">
        <div class="menu-top-container">
            <a href="<?php echo Yii::app()->createUrl('video'); ?>">
                <div class="menu-btn watch"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('downloads'); ?>">
                <div class="menu-btn downloads"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('favorites'); ?>">
                <div class="menu-btn fav"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('contactfaq'); ?>">
                <div class="menu-btn information"></div>
            </a>
            
        </div>
    </div>

    <?php echo $content; ?>
    
    
    <footer>
        
        <?php 
        if ($backend) { 
            echo "<pre>" . 
            count(Organization::model()->getAllOrgs()) ." Organizations       ".
            count(Event::model()->getAllEvents()). " Events       ".
            count(Video::model()->getAllVideos()). " Videos       " . 
            Yii::app()->user->getState('getDirSizeVideo') . " Of video storage used" .
            "</pre>";
        } else {
        ?>
            Streaming App
        <?php
        }
        ?>
    </footer>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>

    <script type="text/javascript">

        //check if using mobile safari [returns true is mobile safari] =====

        var ua = window.navigator.userAgent;
        var iOS = !!ua.match(/iPad/i) || !!ua.match(/iPhone/i);
        var webkit = !!ua.match(/WebKit/i);
        var iOSSafari = iOS && webkit && !ua.match(/CriOS/i);
        //===================================================

        $(window).load(function() {
            /* Small Safari hack (that I don'nt think actually works) to stop Safaris's bottom toolbar 
            from breaking the sticky footer (Safari's bottom toolbar pops up during browsing breaks 
            any clickable areas at bottom of page ) */
            if(iOSSafari) {
                /mobile/i.test(navigator.userAgent) && !window.location.hash && setTimeout(function () {
                    window.scrollTo(0, 1);
                }, 1000);
            }
        });

        var initial = 0;

        if (iOSSafari) {
            /* Big Safari hack (that actually works) to stop Safaris's bottom toolbar from breaking 
            the sticky footer (Safari's bottom toolbar pops up during browsing breaks any clickable 
            areas at bottom of page ) */

            initial = window.innerHeight;

            $("footer").css("background","#e9e8e9");
            $("footer").css("color","#0073c3");

            $(window).resize(function () {
                if (window.innerHeight === initial) {
                    $(".menu-top").animate({ marginBottom: "1px" })
                    
                } else {
                    $(".menu-top").animate({ marginBottom: "40px" })
                }
            })
        }
    </script>
</body>
</html>