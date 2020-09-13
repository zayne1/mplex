<a href="<?php echo Yii::app()->createUrl('backend/organization/view/id/' .CHtml::encode($data->_id)); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display:block;float: left;margin-right: 10px;width: 147px;">
    <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. CHtml::encode($data->logo); ?>" class="organization">
</a>