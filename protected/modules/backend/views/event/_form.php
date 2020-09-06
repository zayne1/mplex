<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

			<div class="row">
			<?php echo $form->labelEx($model,'id'); ?>
			<?php echo $form->textField($model,'id'); ?>
			<?php echo $form->error($model,'id'); ?>
		</div>

				<div class="row" style="display: none;">
			<?php echo $form->labelEx($model,'orgId'); ?>
			<?php echo $form->textField($model,'orgId'); ?>
			<?php echo $form->error($model,'orgId'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

				<div class="row" style="display: none;">
			<?php echo $form->labelEx($model,'logo'); ?>
			<?php echo $form->textField($model,'logo'); ?>
			<?php echo $form->error($model,'logo'); ?>
		</div>

				<div class="row">
			<?php echo $form->labelEx($model,'pass'); ?>
			<?php echo $form->textField($model,'pass'); ?>
			<?php echo $form->error($model,'pass'); ?>
		</div>

			<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->