<?php
/* @var $this CarsController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'Cars'=>array('index'),
	$model->regNo=>array('view','id'=>$model->regNo),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cars', 'url'=>array('index')),
	array('label'=>'Add Car', 'url'=>array('create'))
	// array('label'=>'View Cars', 'url'=>array('view', 'id'=>$model->regNo))
	// array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h3>Update Car <?php echo $model->regNo; ?></h3>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'dropDownData' => $dropDownData
	)); ?>