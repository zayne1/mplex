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
        <div class="row" style="background-color: #c21238;">
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
            <a class="btn-edit-event js-btn-upload-show pull-left" style="margin-left: 30px;background: #454447;color:#fff;" href="#">
                Upload Videos
            </a>

            <a class="btn-edit-event pull-left" style="margin-left: 30px;" 
                href="<?php echo Yii::app()->createUrl('backend/event/update/id/' . CHtml::encode($model->_id)); ?>">
                Edit Event
            </a>
        
            

            

            <a class="btn-edit-event pull-left" style="margin-left: 30px;" id="<?php echo CHtml::encode($model->_id); ?>" href="#">         
                Delete event

                <!-- We use the js below to use a controller's delete via POST as we cannot just create a param (it only accepts POST for delete.
                We copied this code from what Yii's Gii CRUD generated to do deletions (with slight mods to return to current page:) 
                -->
                <script type="text/javascript">
                    /*<![CDATA[*/
                    jQuery(function($) {
                    jQuery('body').on('click','#<?php echo CHtml::encode($model->_id);?>',function(){
                        if(confirm('Are you sure you want to delete this item?')) 
                        {jQuery.yii.submitForm(this,'/backend/event/delete/id/<?php echo CHtml::encode($model->_id);?>',{'returnUrl':'/backend/index'});return false;} else return false;});
                    });
                    /*]]>*/
                </script>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="form">
            <!--<div>Header</div>-->
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'fileupload',
                
                // Client side validation
                'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )); ?>

                
            
            
                <div class="row">
                    <div style="margin-left: 30px;margin-top: 10px;margin-bottom: 10px;">
                        Add files, then Upload them, then refresh page to see updated list.
                    </div>
                    <?php
                    $this->widget( 'xupload.XUpload', array(
                        'url' => Yii::app()->createUrl( "/backend/upload"),
                        //our XUploadForm
                        'model' => $xupload_form_model,
                        //We set this for the widget to be able to target our own form
                        'htmlOptions' => array('id'=>'fileupload'),
                        'attribute' => 'file',
                        'multiple' => true,
                        //Note that we are using a custom view for our widget
                        //Thats becase the default widget includes the 'form' 
                        //which we don't want here
        //                'formView' => 'application.views.gallery._form',
                        )    
                    );
                    ?>
                    
                </div>

                        

            
        <?php $this->endWidget(); ?>
        </div>  
    </div>

    <div class="row">
        <h3 class="pull-left">Videos</h3>
        <h3 class="pull-right">Sort by Name / Size / Date</h3>
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
        'viewData'=>array('video'=>$video),
    )); ?>
    
</div>

<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        $('.js-btn-upload-show').click(function (e) {
            e.preventDefault();
            $('#fileupload').toggle('slow');
        }) 
    });
    /*]]>*/
</script>