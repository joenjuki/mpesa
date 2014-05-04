<?php
/* @var $this GpsDeviceController */
/* @var $model GpsDevice */

$this->breadcrumbs=array(
	'Gps Devices'=>array('index'),
	$model->deviceId,
);

$this->menu=array(
	array('label'=>'List Gps Device', 'url'=>array('index')),
	array('label'=>'Create Gps Device', 'url'=>array('create')),
	// array('label'=>'Update GpsDevice', 'url'=>array('update', 'id'=>$model->deviceId)),
	array('label'=>'Delete Gps Device', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->deviceId),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage GpsDevice', 'url'=>array('admin')),
);
?>

<h1>View GpsDevice #<?php echo $model->deviceId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'deviceId',
		'phoneNumber',
		'password',
		'authorizedNumbers',
	),
)); ?>
