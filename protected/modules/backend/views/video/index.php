<?php
$this->breadcrumbs=array(
	'Videos',
);

$this->menu=array(
	// array('label'=>'Create Video', 'url'=>array('create')),
	// array('label'=>'Manage Video', 'url'=>array('admin')),
);
?>

<h1>Videos</h1>
( Click an ID link to enter record )
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>