<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<h3 class="pull-left">All Organizations</h3>
<h3 class="pull-right">Sort</h3>
<hr/>
<?php 
foreach ($OrgList as $org) {
?>
    <a href="<?php echo Yii::app()->createUrl('backend/organization/view/id/' .$org->_id); ?>" class="animate__animated animate__slideInLeft animate__fast" style="display:block;float: left;margin-right: 10px;width: 147px;">
        <img src="<?php echo Yii::app()->request->baseUrl .'/images/'. $org->logo; ?>" class="organization">
    </a>
<?php
} 
?>

<div style="height: 50px;clear: both;"></div>

<h3 class="pull-left">All Events</h3>
<h3 class="pull-right">Sort</h3>
<hr/>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$eventDataProvider,
    'itemView'=>'_index_event_view',
        'sortableAttributes'=>array(
        'name',
        'date',
    ),
)); ?>
