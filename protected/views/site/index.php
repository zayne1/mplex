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
	<?php 
	foreach ($OrgList as $org) {
	?>
		<a href="<?php echo Yii::app()->createUrl('event?org=' .$org->_id); ?>" class="animate__animated animate__slideInLeft animate__fast pull-left organization-img-container">
			<img src="<?php echo Yii::app()->request->baseUrl .'/images/'. $org->logo; ?>" class="organization">
		</a>
	<?php
	} 
	?>
</div>