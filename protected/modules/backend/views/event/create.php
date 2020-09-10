<?php
$this->breadcrumbs=array(
	'Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Event', 'url'=>array('index')),
	// array('label'=>'Manage Event', 'url'=>array('admin')),
);
?>

<h1>Create Event1</h1>

<?php echo $this->renderPartial('_form', 
    array(  'model'=>$model,
            'OrganizationList' => $OrganizationList,
            'videoUploadModel'=>$videoUploadModel,
    )
); ?>