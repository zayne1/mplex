<?php
$this->breadcrumbs=array(
	'Videos'=>array('index'),
	$model->id=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Video', 'url'=>array('index')),
	// array('label'=>'Create Video', 'url'=>array('create')),
	array('label'=>'View Video', 'url'=>array('view', 'id'=>$model->_id)),
	// array('label'=>'Manage Video', 'url'=>array('admin')),
);
?>

<h1>Update Video <?php echo $model->_id; ?></h1>

<?php 
echo $this->renderPartial('_form', array(
    'model'=>$model,
    'videoUploadModel'=>$videoUploadModel,
    )
); 
?>