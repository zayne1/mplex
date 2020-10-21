<div class="page-name">
    <?php echo $introText; ?>
</div>
<div class="main-content">
    <h3><?php echo $introSubText; ?>XX1</h3>
<?php 
$count=1;
foreach ($EventList as $event) {
	$even_odd_class = ($count % 2 ? 'odd' : 'even');
?>
	<div class="event-container <?php echo $even_odd_class;?> ">
	    <a href="<?php echo '#myModal'.$count;?>" data-toggle="modal" id="link-myModal1">
	        <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. $event->logo; ?>" class="event animate__animated animate__slideInLeft animate__fast">
	        <?php echo $event->name; ?>
	    </a>
	</div>

	<!-- Modal -->
	<div id="<?php echo 'myModal'.$count; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h3 id="myModalLabel">Sign in (password: <?php echo $event->pass;?>)</h3>
	    </div>
	    <div class="modal-body">
	        <h3>Recital 2017 Wednesday</h3>

	        <form id="login-form" action="/event?eventId=<?php echo $event->_id; ?>" method="post">
		        <label for="LoginForm_password" class="required">Password <span class="required">*</span></label>					
		        <input name="LoginForm[password]" id="LoginForm_password" type="password">			
		        <div class="errorMessage" id="LoginForm_password_em_" style="display:none"></div>
		        <br>
				<input type="submit" name="" value="Next" class="sign-submit">
        	</form>
	        <br/>
	    </div>
	    <div class="modal-footer">
	    </div>
	</div>
	<script type="text/javascript">
		/*<![CDATA[*/
	    jQuery(function($) {
	    	
			const fakeInput = document.createElement('input');

			/*Iphone hack: To get autofocus (& therefore keyboard popup) working on iphone, we need to create a click event with some dummy fake input shit */
			$('#link-<?php echo 'myModal'.$count; ?>').on('touchstart click', function () {	  
				// create invisible dummy input to receive the focus first
				fakeInput.setAttribute('type', 'text');
				fakeInput.style.position = 'absolute';
				fakeInput.style.opacity = 0;
				fakeInput.style.height = 0;
				fakeInput.style.fontSize = '16px'; // disable auto zoom

				// you may need to append to another element depending on the browser's auto 
				// zoom/scroll behavior
				document.body.prepend(fakeInput);
				fakeInput.focus();

				// here we hand focus control to the actual target input
  				$('#<?php echo 'myModal'.$count; ?> #LoginForm_password').focus();
			})

			// normal txt focus for web/android. Iphone hack is done in the above hacky block
			$('#<?php echo 'myModal'.$count; ?>').on('shown', function () {
				$('#<?php echo 'myModal'.$count; ?> #LoginForm_password').focus();
			})
	    });
	    /*]]>*/
    </script>
<?php
$count++;
}
?>


	

	<!-- Modal -->
	<div id="myModal0" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
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