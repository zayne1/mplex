<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

					<div class="row">
			<?php echo $form->label($model,'_id'); ?>
			<?php echo $form->textField($model,'_id'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'eventId'); ?>
			<?php echo $form->textField($model,'eventId'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'path'); ?>
			<?php echo $form->textField($model,'path'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'file'); ?>
			<?php echo $form->textField($model,'file'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'fav'); ?>
			<?php echo $form->textField($model,'fav'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'downloaded'); ?>
			<?php echo $form->textField($model,'downloaded'); ?>
		</div>

		<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->