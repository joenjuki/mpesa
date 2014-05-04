<?php
/* @var $this GpsDeviceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Gps Devices',
);

$this->menu=array(
	array('label'=>'Add Gps Device', 'url'=>array('create'))
	// array('label'=>'Manage Gps Device', 'url'=>array('admin')),
);
?>

<h3>Gps Devices</h3>

<script type="text/javascript">
$(document).ready(function($) {
	// Stuff to do as soon as the DOM is ready;
	$('#gpsDeviceTable').dataTable({
		"aaData": <?php echo json_encode($gpsDeviceArray); ?>,
		"aoColumns": [
		<?php
		if(Yii::app()->user->checkAccess('GpsDevice.Update') && Yii::app()->user->checkAccess('GpsDevice.Delete')) {
		?>
			{"mDataProp": null, "sDefaultContent": '<button class="bedit">Edit</button>', 'bSortable': false},
			{"mDataProp": null, "sDefaultContent": '<button class="bdelete">Delete</button>', 'bSortable': false},
		<?php
		}
		?>
			{"mDataProp": "deviceId"},
			{"mDataProp": "phoneNumber"},
			{"mDataProp": "password"},
			{"mDataProp": "authorizedNumbers"}
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
			$('.bedit', nRow).attr( "onclick", "editDevice('" + aData.deviceId + "')" );
			$('.bdelete', nRow).attr( "onclick", "deleteDevice('" + aData.deviceId + "')" );
			
		}

	});

	editDevice = function(deviceId) {
		if(deviceId != '' && deviceId != 'undefined') {
			window.location = '<?php echo CController::createUrl("gpsDevice/update"); ?>/id/' + deviceId;
		}
	}
	deleteDevice = function(deviceId) {
		if(deviceId != '' && deviceId != 'undefined') {
			var confirmDelete = confirm("Are you sure you want to delete device" + deviceId);
			if (confirmDelete) {
				window.location = '<?php echo CController::createUrl("gpsdevice/delete"); ?>/id/' + deviceId;
			}
		}
	}
});
</script>
<table id="gpsDeviceTable" width="100%">
	<thead>
		<tr>
			<?php
			if(Yii::app()->user->checkAccess('GpsDevice.Update') && Yii::app()->user->checkAccess('GpsDevice.Delete')) {
			?>
			<th title="Edit"></th>
			<th title="Delete"></th>
			<?php 
			}
			?>
			<th>Device Id</th>
			<th>Phone Number</th>
			<th>Password</th>
			<th>Authorized Numbers</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
