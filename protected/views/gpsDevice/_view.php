<?php
/* @var $this GpsDeviceController */
/* @var $data GpsDevice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('deviceId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->deviceId), array('view', 'id'=>$data->deviceId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phoneNumber')); ?>:</b>
	<?php echo CHtml::encode($data->phoneNumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('authorizedNumbers')); ?>:</b>
	<?php echo CHtml::encode($data->authorizedNumbers); ?>
	<br />


</div>