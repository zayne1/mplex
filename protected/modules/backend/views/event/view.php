<div class="pg-event-view">
    <?php
    $this->breadcrumbs=array(
    	'Events'=>array('index'),
    	$model->name,
    );

    $this->menu=array(
    	array('label'=>'List Event', 'url'=>array('index')),
    	array('label'=>'Create Event', 'url'=>array('create')),
    	array('label'=>'Update Event', 'url'=>array('update', 'id'=>$model->_id)),
    	array('label'=>'Delete Event', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
    	// array('label'=>'Manage Event', 'url'=>array('admin')),
    );
    ?>

    <h3 class="pull-left">Event Page</h3>
    <hr/>
    <!-- <h1>View Event #<?php echo $model->_id; ?></h1> -->
    <div class="row">
        <div class="row">
            <?php $this->widget('zii.widgets.CDetailView', array(
            	'data'=>$model,
            	'attributes'=>array(
            		// '_id',
                    'name',
                    'date',
                    'location',
                    'orgId',
                    'type',
                    'logo',
                    'pass',
            	),
            )); ?>

            <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. $model->logo; ?>" class="event" style="float: right;width: 30%;">
        </div>

        <div class="row">
            <div class="pull-right video-count">
                <?php echo $videoDataProvider->calculateTotalItemCount();?> Videos
            </div>
        </div>
        <div class="row">
            <a class="btn-edit-event pull-left" style="margin-left: 30px;" 
                href="<?php echo Yii::app()->createUrl('backend/event/update/id/' . CHtml::encode($model->_id)); ?>">
                Edit Event
            </a>
        </div>
    </div>

    <div class="row">
        <h3 class="pull-left">Videos</h3>
        <h3 class="pull-right">Sort</h3>
        <hr/>
    </div>

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$videoDataProvider,
        'itemView'=>'_event_video_view',
            'sortableAttributes'=>array(
            'label' => 'Name',
            'size',
            'date',
        ),
    )); ?>
    
</div>