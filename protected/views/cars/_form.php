<?php
/* @var $this CarsController */
/* @var $model Cars */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cars-form',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'regNo'); ?>
		<?php echo $form->textField($model,'regNo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'regNo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deviceId'); ?>
		<?php echo $form->dropdownList($model, 'deviceId', $dropDownData['devices'], array(
		'class' => 'dropDown',
		'data-placeholder' => 'Select device',
		)); ?>
		<?php echo $form->error($model,'deviceId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'ownerId'); ?>
		<?php echo $form->dropdownList($model, 'ownerId', $dropDownData['owners'], array(
		'class' => 'dropDown',
		'data-placeholder' => 'Select owner',
		)); ?>
		<?php echo $form->error($model,'ownerId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'make'); ?>
		<?php echo $form->textField($model,'make',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'make'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->