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
				'dateFormat' =>'yy-mm-dd',
				'altFormat' =>'yy-mm-dd',
				'changeMonth' => true,
				'changeYear' => true,
				'appendText' => 'yyyy-mm-dd',
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
		
		<div class="row">
		<?php 
		echo $form->labelEx($model, 'vidfiles');
		echo '<label>After adding a file, click "Choose File" again to add another to the list</label>';
		$this->widget('CMultiFileUpload', array(
		       'model'=>$videoUploadModel,
		       // 'model'=>$model,
		       'attribute'=>'vidfiles',
		       'accept'=>'mp4|MP4',
		       'options'=>array(
		       //    'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
		          // 'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
		       //    'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
		       //    'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
		       //    'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
		       //    'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
		       ),
		    ));
		?>
		</div>
	<br>
	<br>
	<br>
	<br>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->