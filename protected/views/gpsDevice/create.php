<?php
/* @var $this GpsDeviceController */
/* @var $model GpsDevice */

$this->breadcrumbs=array(
	'Gps Devices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Gps Device', 'url'=>array('index'))
	// array('label'=>'Manage Gps Device', 'url'=>array('admin')),
);
?>

<h3>Create GpsDevice</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>