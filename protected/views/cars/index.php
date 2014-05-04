<?php
/* @var $this CarsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cars',
);
$this->menu=array(
	array('label'=>'Add Cars', 'url'=>array('create'), 'visible' => Yii::app()->user->checkAccess('Cars.Create'))
	// array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>Cars</h1>

<?php 
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); 
?>
<script type="text/javascript">
$(document).ready(function($) {
	// Stuff to do as soon as the DOM is ready;
	$('#carsTable').dataTable({
		"aaData": <?php echo json_encode($carsArray); ?>,
		"aoColumns": [
		<?php
		if(Yii::app()->user->getIsSuperuser()) {
		?>
			{"mDataProp": null, "sDefaultContent": '<button class="bedit">Edit</button>', 'bSortable': false},
			{"mDataProp": null, "sDefaultContent": '<button class="bdelete">Delete</button>', 'bSortable': false},
		<?php
		}
		?>
			{"mDataProp": "regNo"},
			{"mDataProp": "ownerId"},
			{"mDataProp": "deviceId"},
			{"mDataProp": "make"},
			{"mDataProp": "model"}
		],
		"fnDrawCallback": function() {
			$('.bedit').button({
				icons: { primary: "ui-icon-pencil" }, 
				text: false
			});
			$('.bdelete').button({
				icons: { primary: "ui-icon-trash" }, 
				text: false
			});
		},
		"fnRowCallback": function( nRow, aData,iDisplayIndex, iDisplayIndexFull ) {
			$('.bedit', nRow).attr( "onclick", "editCar('" + aData.regNo + "')" );
			$('.bdelete', nRow).attr( "onclick", "deleteCar('" + aData.regNo + "')" );
			
		}

	});

	editCar = function(regNo) {
		if(regNo != '' && regNo != 'undefined') {
			window.location = '<?php echo CController::createUrl("cars/update"); ?>/id/' + regNo;
		}
	}
	deleteCar = function(regNo) {
		if(regNo != '' && regNo != 'undefined') {
			var confirmDelete = confirm("Are you sure you want to delete " + regNo);
			if (confirmDelete) {
				window.location = '<?php echo CController::createUrl("cars/delete"); ?>/id/' + regNo;
			}
		}
	}
});
</script>
<table id="carsTable" width="100%">
	<thead>
		<tr>
			<?php
			if(Yii::app()->user->getIsSuperuser()) {
			?>
			<th title="Edit"></th>
			<th title="Delete"></th>
			<?php 
			}
			?>
			<th>Registration No</th>
			<th>Owner</th>
			<th>Device Id</th>
			<th>Make</th>
			<th>Model</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
