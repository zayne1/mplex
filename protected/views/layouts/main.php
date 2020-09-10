<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCssFile('/css/bootstrap.css');
    $cs->registerCssFile('/css/fa/css/font-awesome.min.css');
    $cs->registerCssFile('/css/animate.min.css');
    $cs->registerCssFile('/css/metroplex.css');
    ?>


	<style type="text/css">
        .menu-top
        {
            display: none;
        }
        .icon-green {
            color:#42B142;
        }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
</head>



<body>
    <div class="header">
        <hr/>
        <!-- <a href="index.php"> -->
        <a href="<?php echo Yii::app()->createUrl(' '); ?>">
            <img class="home-icon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-home.png">
        </a>
        <?php
        if ( isset(Yii::app()->controller->module->is_backend) && (Yii::app()->controller->module->is_backend==true)) {
        ?>
            <a href="<?php echo Yii::app()->createUrl('backend/index'); ?>" class="backend btn-dashboard-home">Dashboard home</a>
            <a href="<?php echo Yii::app()->createUrl('backend/organization/create'); ?>" class="backend btn-new-org">New Org</a>
            <a href="<?php echo Yii::app()->createUrl('backend/event/create'); ?>" class="backend btn-new-event">New Event</a>
        <?php
        }
        ?>
        <img class="logo-txt" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-txt.png">
    </div>
    <div class="menu-top">
        <div class="menu-top-container">
            <a href="<?php echo Yii::app()->createUrl('video'); ?>">
                <div class="menu-btn watch"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('downloads'); ?>">
                <div class="menu-btn downloads"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('favourites'); ?>">
                <div class="menu-btn fav"></div>
            </a>
            <a href="<?php echo Yii::app()->createUrl('contactfaq'); ?>">
                <div class="menu-btn information"></div>
            </a>
            
        </div>
    </div>

    <?php echo $content; ?>
    
    
    <footer>
        Streaming App
    </footer>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.multifile.js"></script>
    
</body>
</html>  

