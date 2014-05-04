<?php
/* @var $this CompaniesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Companies',
);

$this->menu=array(
	array('label'=>'Create Companies', 'url'=>array('create'))
	// array('label'=>'Manage Companies', 'url'=>array('admin')),
);
?>
<h3>Companies</h3>
<script type="text/javascript">
$(document).ready(function($) {
	// Stuff to do as soon as the DOM is ready;
	$('#companiesTable').dataTable({
		"aaData": <?php echo json_encode($companiesArray); ?>,
		"aoColumns": [
		<?php
		if(Yii::app()->user->checkAccess('Companies.Update') && Yii::app()->user->checkAccess('Companies.Delete')) {
		?>
			{"mDataProp": null, "sDefaultContent": '<button class="bedit">Edit</button>', 'bSortable': false},
			{"mDataProp": null, "sDefaultContent": '<button class="bdelete">Delete</button>', 'bSortable': false},
		<?php
		}
		?>
			{"mDataProp": "id"},
			{"mDataProp": "name"},
			{"mDataProp": "email"},
			{"mDataProp": "address"}
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
			$('.bedit', nRow).attr( "onclick", "editCompany('" + aData.id + "')" );
			$('.bdelete', nRow).attr( "onclick", "deleteCompany('" + aData.id + "')" );
			
		}

	});

	editCompany = function(id) {
		if(id != '' && id != 'undefined') {
			window.location = '<?php echo CController::createUrl("companies/update"); ?>/id/' + id;
		}
	}
	deleteCompany = function(id) {
		if(id != '' && id != 'undefined') {
			var confirmDelete = confirm("Are you sure you want to delete company" + id);
			if (confirmDelete) {
				window.location = '<?php echo CController::createUrl("companies/delete"); ?>/id/' + id;
			}
		}
	}
});
</script>
<table id="companiesTable" width="100%">
	<thead>
		<tr>
			<?php
			if(Yii::app()->user->checkAccess('Companies.Update') && Yii::app()->user->checkAccess('Companies.Delete')) {
			?>
			<th title="Edit"></th>
			<th title="Delete"></th>
			<?php 
			}
			?>
			<th>Company Id</th>
			<th>Company Name</th>
			<th>Email</th>
			<th>Address</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>