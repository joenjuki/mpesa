<?php
/* @var $this CarsController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'Cars'=>array('index'),
	$model->regNo,
);

$this->menu=array(
	array('label'=>'List Cars', 'url'=>array('index')),
	array('label'=>'Create Cars', 'url'=>array('create')),
	array('label'=>'Update Cars', 'url'=>array('update', 'id'=>$model->regNo)),
	array('label'=>'Delete Cars', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->regNo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>View Cars #<?php echo $model->regNo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'regNo',
		'deviceId',
		'ownerId',
		'model',
		'make',
	),
)); ?>
