<div class="view">
		<b><?php echo CHtml::encode($data->getAttributeLabel('_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->_id), array('view', 'id'=>$data->_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eventId')); ?>:</b>
	<?php echo CHtml::encode($data->eventId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('path')); ?>:</b>
	<?php echo CHtml::encode($data->path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
	<?php echo CHtml::encode($data->file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fav')); ?>:</b>
	<?php echo CHtml::encode($data->fav); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('downloaded')); ?>:</b>
	<?php echo CHtml::encode($data->downloaded); ?>
	<br />


</div>