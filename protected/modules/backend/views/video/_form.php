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


<?php
	$form2 = $this->beginWidget(
	'CActiveForm',
	array(
		// 'action' => array('video/upload', 'page'=>3),
		// 'action' => array('video/upload'),
		'action' => array('upload'),
		'id' => 'upload-form2',
		'enableAjaxValidation' => true,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)
);

  
    $this->widget('CMultiFileUpload', array(
       'model'=>$videoUploadModel,
       'attribute'=>'files',
       'accept'=>'mp4|MP4',
       // 'options'=>array(
       //    'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
       //    'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
       //    'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
       //    'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
       //    'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
       //    'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
       // ),
    ));

echo CHtml::submitButton('Save video');
$this->endWidget();
?>

</div><!-- form -->