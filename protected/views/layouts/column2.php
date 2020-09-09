<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<!-- <div class="span-19"> -->
<div class="layout-col-2">
	<div id="content">

		<?php
		if ($message = Yii::app()->user->getFlash('videoSavedStatus')) {
			echo '<div class="flash-success">'.$message.'</div>';
		}?>
		
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>