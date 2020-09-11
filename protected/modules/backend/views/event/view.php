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
                <?php echo count($vidList);?> Videos
            </div>
        </div>
    </div>

    <div class="row">
        <h3 class="pull-left">Videos</h3>
        <h3 class="pull-right">Sort</h3>
        <hr/>
    </div>

    <?php 
    foreach ($vidList as $vid) {
    ?>
        <div class="row vid-row-item">

            
            <a id="<?php echo $vid->_id; ?>" href="#">
                <i class="icon-trash icon-2x"></i>
                <!-- We use the js below to use a controller's delete via POST as we cannot just create a param (it only accepts POST for delete.
                We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
                -->
                <script type="text/javascript">
                    /*<![CDATA[*/
                    jQuery(function($) {
                    jQuery('body').on('click','#<?php echo $vid->_id;?>',function(){
                        if(confirm('Are you sure you want to delete this item?')) 
                        {jQuery.yii.submitForm(this,'/backend/video/delete/id/<?php echo $vid->_id;?>',{'returnUrl':window.location.href});return false;} else return false;});
                    });
                    /*]]>*/
                </script>
            </a>

            <img src="<?php echo Yii::app()->request->baseUrl .'/images/videothumb.png' ?>" class="video-thumb">

            <a href="<?php echo Yii::app()->createUrl('backend/event/view/id/' .$vid->_id); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display:block;float: left;margin-right: 10px;width: 147px;">
            </a>
            <?php echo $vid->label; ?>
        </div>
        <br>
    <?php
    } 
    ?>
</div>