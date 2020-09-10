<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->dropDownList($model , 'co_type', array(
					'Dance Studio'=>'Dance Studio',
					'Cheer Organization'=>'Cheer Organization',
					'Individual'=>'Individual',
					'General Video'=>'General Video',
					'Theatre'=>'Theatre',
					'High School'=>'High School',
					'Music Organization'=>'Music Organization',
					'Band'=>'Band',
					'Company'=>'Company',
				),
				 array('empty' => 'Select a Company Type')); 
			 ?>  
		 </div>

		<div class="row">
			<?php echo $form->labelEx($model,'contact_person'); ?>
			<?php echo $form->textField($model,'contact_person'); ?>
			<?php echo $form->error($model,'contact_person'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone'); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'website'); ?>
			<?php echo $form->textField($model,'website'); ?>
			<?php echo $form->error($model,'website'); ?>
		</div>



		<div class="row">
			<?php //echo $form->labelEx($model,'orgId'); ?>
			<?php //echo $form->textField($model,'orgId'); ?>
			<?php //echo $form->error($model,'orgId'); ?>
		</div>


<?php
		// We don't set the db val with this, but rather we force it in the EventController's
		// create action. Have a look there
		echo $form->labelEx($model, 'logo');
		echo $form->fileField($model, 'logo');
		echo $form->error($model, 'logo');
?>

			<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->