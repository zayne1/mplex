<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'video-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

			<div class="row">
			<?php echo $form->labelEx($model,'eventId'); ?>
			<?php echo $form->textField($model,'eventId'); ?>
			<?php echo $form->error($model,'eventId'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'path'); ?>
			<?php echo $form->textField($model,'path'); ?>
			<?php echo $form->error($model,'path'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'file'); ?>
			<?php echo $form->textField($model,'file'); ?>
			<?php echo $form->error($model,'file'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'fav'); ?>
			<?php echo $form->textField($model,'fav'); ?>
			<?php echo $form->error($model,'fav'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'downloaded'); ?>
			<?php echo $form->textField($model,'downloaded'); ?>
			<?php echo $form->error($model,'downloaded'); ?>
		</div>

			<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->