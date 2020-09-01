<style type="text/css">
    .menu-top
    {
        display: none;
    }
</style>

<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>

	<a href="<?php echo Yii::app()->createUrl('event'); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display:block;float: left;margin-right: 10px;">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/org1.png" class="organization">
	</a>

</div>