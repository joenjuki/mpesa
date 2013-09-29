
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
		$cs = Yii::app()->getClientScript();
		Yii::app()->clientScript->registerCoreScript('jquery');
	?>
		<!-- Fav and Touch and touch icons -->
		<link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
		
	<?php  
		$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
		$cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
		$cs->registerCssFile($baseUrl.'/css/abound.css');
		//$cs->registerCssFile($baseUrl.'/css/style-blue.css');
		?>
			<!-- styles for style switcher -->
				<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/style-green.css" />
		<?php
		$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/charts.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
		// $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
		// $cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
	?>
	<style>
		/*body {
			background-color: #468847;
		}*/
	</style>
	</head>

<body>
<section class="main-body">
		<div class="container-fluid-login">
						<!-- Include content pages -->
						<?php echo $content; ?>
		</div>
</section>

<!-- Require the footer -->
<?php require_once('tpl_footer.php'); ?>

	</body>
</html>