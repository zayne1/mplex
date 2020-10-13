<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

			<div class="row">
			<?php echo $form->labelEx($model,'id'); ?>
			<?php echo $form->textField($model,'id'); ?>
			<?php echo $form->error($model,'id'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		
		<div class="row">
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
				'name' => 'date',
				'attribute' => 'date',
				'model'=>$model,
				'options'=> array(
				'dateFormat' =>'mm-dd-yy',
				'altFormat' =>'mm-dd-yy',
				'changeMonth' => true,
				'changeYear' => true,
				'appendText' => 'mm-dd-yyyy',
				),
			));
			?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'location'); ?>
			<?php echo $form->textField($model,'location'); ?>
			<?php echo $form->error($model,'location'); ?>
		</div>

		<div class="row">
			<?php echo $form->dropDownList($model , 'orgId', 
				CHtml::listData($OrganizationList,'_id','name'),
				array('empty' => 'Select Org')); 
			 ?>  
		 </div>

		<div class="row">
			<?php echo $form->dropDownList($model , 'type', array(
					'Music Concert'=>'Music Concert',
					'Music Concert'=>'Music Concert',
					'Lecturer'=>'Lecturer',
					'Theatre Production'=>'Theatre Production',
					'Cheer Competition'=>'Cheer Competition',
					'General Video'=>'General Video',
					'Automotive Event'=>'Automotive Event',
					'Tournament'=>'Tournament',
				),
				 array('empty' => 'Select an Event Type')); 
			 ?>  
		 </div>

		<div class="row">
			<?php echo $form->labelEx($model,'pass'); ?>
			<?php echo $form->textField($model,'pass'); ?>
			<?php echo $form->error($model,'pass'); ?>
		</div>
		<div class="row">
		<?php
		// We don't set the db val with this, but rather we force it in the EventController's
		// create action. Have a look there
		echo $form->labelEx($model, 'logo');
		echo $form->fileField($model, 'logo');
		echo $form->error($model, 'logo');
		?>
		</div>
		
		<br><br>
		
	<!-- <br>
	<br>
	<br>
	<br> -->
	<div class="row buttons btn-save-event-row" style="margin-top: 50px;">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save Event' : 'Save Event'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->