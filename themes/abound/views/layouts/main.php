
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<!-- <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'> -->

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<?php
		$baseUrl = Yii::app()->theme->baseUrl; 
		$appBaseUrl = Yii::app()->request->baseUrl;
		$cs = Yii::app()->getClientScript();
		Yii::app()->clientScript->registerCoreScript('jquery');
	    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	    // $cs->registerScriptFile($appBaseUrl . '/libraries/jquery-google-maps-v3/jquery.ui.map.js');
	    // $cs->registerScriptFile($appBaseUrl . '/libraries/jquery-google-maps-v3/jquery.ui.map.extensions.js');
		$cs->registerScriptFile($appBaseUrl . '/libraries/DataTables-1.9.4/media/js/jquery.dataTables.min.js');
		$cs->registerScriptFile($appBaseUrl . '/libraries/chosen_v1.1.0/chosen.jquery.min.js');
		$cs->registerScriptFile($appBaseUrl . '/libraries/leaflet-0.7.2/leaflet.js');
		$cs->registerScriptFile($appBaseUrl . '/libraries/Leaflet.PolylineDecorator-leaflet-0.7.2/leaflet.polylineDecorator.js');
		$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/charts.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
		$cs->registerScriptFile($appBaseUrl.'/libraries/jquery-ui-1.10.4-custom/jquery-ui-1.10.4.custom.min.js');
		$cs->registerScriptFile($appBaseUrl.'/libraries/main_ui.js');
	?>
	<?php  
		$cs->registerCssFile($appBaseUrl . '/css/form.css');
		$cs->registerCssFile($appBaseUrl . '/css/main.css');
		$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
		$cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
		$cs->registerCssFile($baseUrl.'/css/abound.css');
		$cs->registerCssFile($appBaseUrl . '/libraries/custom-theme/jquery-ui-1.10.4.custom.min.css');
	    $cs->registerCssFile($appBaseUrl . '/libraries/DataTables-1.9.4/media/css/jquery.dataTables.css');
		$cs->registerCssFile($appBaseUrl . '/libraries/chosen_v1.1.0/chosen.css');
		$cs->registerCssFile($appBaseUrl . '/libraries/leaflet-0.7.2/leaflet.css');
	

		//$cs->registerCssFile($baseUrl.'/css/style-blue.css');
		?>
		<!-- // <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script> -->
		<!-- // <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> -->

			<!-- styles for style switcher -->
				<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/style-green.css" />
		<?php 
		//echo session.gc_maxlifetime
		// print_r(Yii::app()->user->loginRequiredAjaxResponse); die();
		if (Yii::app()->user->loginRequiredAjaxResponse){
	        Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
	            jQuery("body").ajaxComplete(
	                function(event, request, options) {
	                    if (request.responseText == "' . Yii::app()->user->loginRequiredAjaxResponse . '") {
	                        window.location.href = "' . Yii::app()->createUrl('/user/login').'";
	                    }
	                }
	            );
	        ');
	    }

	?>
	</head>

<body>

<section id="navigation-main">   
<!-- Require the navigation -->
<?php require_once('tpl_navigation.php'); ?>
</section><!-- /#navigation-main -->
<section class="main-body">
		<div class="container-fluid">
<?php
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	foreach ($flashMessages as $key => $message) {
		if ($key != 'error') {
			Yii::app()->clientScript->registerScript(
				'myHideEffect', 
				'$(".flash-' . $key . '").animate({opacity: 1.0}, 2000).fadeOut("slow");',
				CClientScript::POS_READY
				);
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		} else {
			echo '<div id="flashMsgWrapper" class="flash-' . $key . '">' . $message . 
				'<input id = "closeButtonFlash" class="ui-icon ui-icon-closethick" type="button" value="close" />'."</div>\n";
		}
	}
}		
?>
						<!-- Include content pages -->
						<?php echo $content; ?>
		</div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php'); ?>

	</body>
</html>