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
			<?php echo $form->label($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
		</div>

				<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->