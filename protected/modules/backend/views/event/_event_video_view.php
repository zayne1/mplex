<div class="row vid-row-item">

            
    <a id="<?php echo CHtml::encode($data->_id); ?>" href="#" style="display: block;float: left;margin-right: 15px;">
        <i class="icon-trash icon-2x"></i>
        <!-- We use the js below to use a controller's delete via POST as we cannot just create a param (it only accepts POST for delete.
        We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
        -->
        <script type="text/javascript">
            /*<![CDATA[*/
            jQuery(function($) {
                jQuery('body').on('click','#<?php echo CHtml::encode($data->_id);?>',function(){
                    if(confirm('Are you sure you want to delete this item?')) 
                    {jQuery.yii.submitForm(this,'/backend/video/delete/id/<?php echo CHtml::encode($data->_id);?>',{'returnUrl':window.location.href});return false;} else return false;
                });
            });
            /*]]>*/
        </script>
    </a>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'thumb-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'style'=>"display: block;float: left;width:33px;margin-right:15px;"),
    )); ?>

        <input type="hidden" value="<?php echo $data->_id;?>" name="Video[videoId]">
        <?php
        // echo $form->labelEx($video, 'thumb');
        echo '<label for="Video-file-id-'.$data->_id.'" id="label-'.$data->_id.'">
                <i class="icon-picture icon-2x"></i>
            </label>';
        echo $form->fileField($video, 'thumb', array('id' => 'Video-file-id-'.$data->_id, 'class'=>'Video-file-input'));
        echo $form->error($video, 'thumb');
        ?>
        
        <?php echo CHtml::submitButton('Save thumb', array('style' => 'position:relative;','class'=>'vid-thumb-save-submit', 'id'=>'submit-'.$data->_id )); ?>

        <!-- Show the correct save button only when upload label img is clicked -->
        <script type="text/javascript">
            /*<![CDATA[*/
            jQuery(function($) {
                jQuery('body').on('click','#<?php echo 'label-'.$data->_id;?>',function(){
                    $('.vid-thumb-save-submit').hide(); //hide all
                    $('#<?php echo 'submit-'.$data->_id;?>').show();
                });
            });
            /*]]>*/
        </script>

    <?php $this->endWidget(); ?>

    <a href="#" class="<?php echo 'js-iconreset-'.CHtml::encode($data->_id);?>" style="display: block;float: left;margin-right: 15px;">
        <!-- <i class="icon-trash icon-2x"></i> -->
        [Reset Icon]
        <!-- 
        We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
        -->
        <script type="text/javascript">
            /*<![CDATA[*/
            jQuery(function($) {
                jQuery('body').on('click',"<?php echo '.js-iconreset-'.CHtml::encode($data->_id);?>",function(){
                    if(confirm('Are you sure you want to reset the video icon?')) 
                    {jQuery.yii.submitForm(this,'/backend/video/iconreset/id/<?php echo CHtml::encode($data->_id);?>',{'returnUrl':window.location.href});return false;} else return false;
                });
            });
            /*]]>*/
        </script>
    </a>


    <img src="<?php echo Yii::app()->request->baseUrl .'/images/videothumbs/'. $data->thumb; ?>" class="video-thumb">

    <?php echo CHtml::encode($data->label); ?>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->date); ?></div>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->sizeLabel); ?></div>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->length); ?></div>
</div>
<br>