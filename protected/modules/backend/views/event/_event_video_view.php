<div class="row vid-row-item">

            
    <a id="<?php echo CHtml::encode($data->_id); ?>" href="#">
        <i class="icon-trash icon-2x"></i>
        <!-- We use the js below to use a controller's delete via POST as we cannot just create a param (it only accepts POST for delete.
        We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
        -->
        <script type="text/javascript">
            /*<![CDATA[*/
            jQuery(function($) {
            jQuery('body').on('click','#<?php echo CHtml::encode($data->_id);?>',function(){
                if(confirm('Are you sure you want to delete this item?')) 
                {jQuery.yii.submitForm(this,'/backend/video/delete/id/<?php echo CHtml::encode($data->_id);?>',{'returnUrl':window.location.href});return false;} else return false;});
            });
            /*]]>*/
        </script>
    </a>

    <img src="<?php echo Yii::app()->request->baseUrl .'/images/videothumb.png' ?>" class="video-thumb">

    <?php echo CHtml::encode($data->label); ?>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->date); ?></div>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->size); ?></div>
    <div style="width: 100px;float: right;margin-top: 15px;"><?php echo CHtml::encode($data->length); ?></div>
</div>
<br>