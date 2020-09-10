<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="backend-index">
	<h2>metroplex multimedia</h2>
	<h2>administration panel</h2>
	
	<img class="home-icon" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-m.png">

	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		
		<div class="row">
			<?php //echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row">
			<?php //echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
			<p class="hint">
				Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>.
			</p>
		</div>

		<!-- <div class="row rememberMe"> -->
			<?php //echo $form->checkBox($model,'rememberMe'); ?>
			<?php //echo $form->label($model,'rememberMe'); ?>
			<?php //echo $form->error($model,'rememberMe'); ?>
		<!-- </div> -->

		<div class="row buttons">
			<?php echo CHtml::submitButton('Login'); ?>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>