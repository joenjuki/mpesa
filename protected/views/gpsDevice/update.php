<?php
/* @var $this GpsDeviceController */
/* @var $model GpsDevice */

$this->breadcrumbs=array(
	'Gps Devices'=>array('index'),
	$model->deviceId=>array('view','id'=>$model->deviceId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Gps Device', 'url'=>array('index')),
	array('label'=>'Add Gps Device', 'url'=>array('create')),
	// array('label'=>'View GpsDevice', 'url'=>array('view', 'id'=>$model->deviceId)),
	// array('label'=>'Manage GpsDevice', 'url'=>array('admin')),
);
?>

<h3>Update GpsDevice <?php echo $model->deviceId; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>