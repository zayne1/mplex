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
			<?php echo $form->label($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
		</div>

					<div class="row">
			<?php echo $form->label($model,'logo'); ?>
			<?php echo $form->textField($model,'logo'); ?>
		</div>

		<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->