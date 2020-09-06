<?php
$this->breadcrumbs=array(
	'Organizations'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Organization', 'url'=>array('index')),
	array('label'=>'Create Organization', 'url'=>array('create')),
	array('label'=>'View Organization', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage Organization', 'url'=>array('admin')),
);
?>

<h1>Update Organization <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>