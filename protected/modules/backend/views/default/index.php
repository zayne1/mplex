<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<h3 class="pull-left">All Organizations</h3>
<h3 class="pull-right">Sort</h3>
<hr/>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$orgDataProvider,
    'itemView'=>'_index_org_view',
        'sortableAttributes'=>array(
        'name',
    ),
)); ?>

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
