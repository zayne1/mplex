<a href="<?php echo Yii::app()->createUrl('backend/event/view/id/' . CHtml::encode($data->_id)); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display:block;float: left;margin-right: 10px;width: 147px;">
    <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. CHtml::encode($data->logo); ?>" class="event">
    <div style="background: #c21238;padding: 5px;color: #fff;text-align: center;height: 45px;margin-bottom: 10px;">
        <?php echo CHtml::encode($data->name); ?>
    </div>
</a>