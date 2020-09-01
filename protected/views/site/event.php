<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?></h3>



	<div class="event-container">
	    <a href="#myModal" data-toggle="modal">
	        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/event.png" class="event">
	        Recital 2017 Wednesday
	    </a>
	</div>
	<!-- <div class="event-container">
	    <a href="#myModal" data-toggle="modal">
	        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/event.png" class="event">
	        Recital 2017 Thursday
	    </a>
	</div>
	<div class="event-container">
	    <a href="#myModal" data-toggle="modal">
	        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/event.png" class="event">
	        Recital 2017 Friday
	    </a>
	</div>
 -->




	<!-- Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h3 id="myModalLabel">Sign in</h3>
	    </div>
	    <div class="modal-body">
	        <h3>Recital 2017 Wednesday</h3>

	        <h3>Please sign in with your password</h3>

	        <?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

	        <input name="LoginForm[username]" id="LoginForm_username" type="hidden" value="demo">
Password is "demo"
	        <!-- <input type="input" name="" class="sign-input"> -->
	        <?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>

	        <div>
				<?php echo $form->checkBox($model,'rememberMe'); ?>
				<?php echo $form->label($model,'rememberMe'); ?>
				<?php echo $form->error($model,'rememberMe'); ?>
			</div>
	        
	        <!-- <input type="submit" name="" value="Next" class="sign-submit"> -->
	        <br/>
			<?php echo CHtml::submitButton('Next', array('class' => 'sign-submit')); ?>
        	
        	<?php $this->endWidget(); ?>

	    </div>
	    <div class="modal-footer">
	    <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
	    <!-- <button class="btn btn-primary">Save changes</button> -->
	    </div>
	</div>
</div>