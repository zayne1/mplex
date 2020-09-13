<a href="<?php echo Yii::app()->createUrl('backend/organization/view/id/' .CHtml::encode($data->_id)); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display: block;
    float: left;
    margin-right: 10px;
    background: #0273c3;
    width: 147px;
    height: 179px;">
    <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. CHtml::encode($data->logo); ?>" class="organization" style="background:#fff; ">
    <div style="background: #0273c3;
    padding: 5px;
    color: #fff;
    text-align: center;
    bottom: 0px;
    position: absolute;
    width: 90%;">
        <?php echo count(Event::model()->getEventsForOrg( (string)$data->_id) );?> Events /
    </div>
</a>
