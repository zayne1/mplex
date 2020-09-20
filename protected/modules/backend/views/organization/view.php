<div class="pg-org-view">
    <?php
    $this->breadcrumbs=array(
    	'Organizations'=>array('index'),
    	$model->name,
    );

    $this->menu=array(
    	array('label'=>'List Organization', 'url'=>array('index')),
    	array('label'=>'Create Organization', 'url'=>array('create')),
    	array('label'=>'Update Organization', 'url'=>array('update', 'id'=>$model->_id)),
    	array('label'=>'Delete Organization', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
    	// array('label'=>'Manage Organization', 'url'=>array('admin')),
    );
    ?>

    <h3 class="pull-left">Organization Page</h3>
    <hr/>

    <!-- <h1>View Organization #<?php //echo $model->_id; ?></h1> -->
    <div class="row">
        <div class="row" style="background: #0273c3;">
            <?php $this->widget('zii.widgets.CDetailView', array(
            	'data'=>$model,
            	'attributes'=>array(
            		// '_id',
                    'name',
                    'co_type',
                    'contact_person',
                    'phone',
                    'email',
                    'website',
                    'logo',
            	),
            )); ?>

            <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. $model->logo; ?>" class="event" style="float: right;width: 30%;">
        </div>
        <div class="row">
            <div class="pull-right video-count">
                <!-- //Number of Events , number of videos go here -->
                <?php echo $eventDataProvider->calculateTotalItemCount();?> Events
            </div>
        </div>
        <div class="row">
            <a class="btn-edit-org pull-left" style="margin-left: 30px;" 
                href="<?php echo Yii::app()->createUrl('backend/organization/update/id/' . CHtml::encode($model->_id)); ?>">
                Edit Org
            </a>

            <a class="btn-edit-org pull-left" style="margin-left: 30px;" id="<?php echo CHtml::encode($model->_id); ?>" href="#">         
                Delete Org

                <!-- We use the js below to use a controller's delete via POST as we cannot just create a param (it only accepts POST for delete.
                We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
                -->
                <script type="text/javascript">
                    /*<![CDATA[*/
                    jQuery(function($) {
                    jQuery('body').on('click','#<?php echo CHtml::encode($model->_id);?>',function(){
                        if(confirm('Are you sure you want to delete this item?')) 
                        {jQuery.yii.submitForm(this,'/backend/organization/delete/id/<?php echo CHtml::encode($model->_id);?>',{'returnUrl':'/backend/index'});return false;} else return false;});
                    });
                    /*]]>*/
                </script>
            </a>
        </div>
    </div>

    <div class="row clearfix">
        <h3 class="pull-left">Events</h3>
        <h3 class="pull-right">Sort by Name / Date</h3>
        <hr/>
    </div>

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$eventDataProvider,
        'itemView'=>'_org_event_view',
            'sortableAttributes'=>array(
            'name',
            'date',
        ),
    )); ?>
</div>