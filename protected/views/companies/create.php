<?php
/* @var $this CompaniesController */
/* @var $model Companies */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Companies', 'url'=>array('index')),
	// array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>

<h3>Create Companies</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>