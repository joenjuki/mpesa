<?php
/* @var $this CarsController */
/* @var $data Cars */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('regNo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->regNo), array('view', 'id'=>$data->regNo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deviceId')); ?>:</b>
	<?php echo CHtml::encode($data->deviceId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ownerId')); ?>:</b>
	<?php echo CHtml::encode($data->ownerId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
	<?php echo CHtml::encode($data->model); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('make')); ?>:</b>
	<?php echo CHtml::encode($data->make); ?>
	<br />


</div>