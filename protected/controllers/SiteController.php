<?php

class SiteController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' action
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// Yii::app()->theme = 'abound';
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		// $sql = "SELECT gpsDevice.phoneNumber, cars.regNo FROM `gpsDevice`" . 
		// " INNER JOIN `cars` ON cars.deviceId = gpsDevice.deviceId";
		
		$rsRegNoPlusDevice = Yii::app()->db->createCommand()
		->select('gpsDevice.phoneNumber, cars.regNo')
		->from('gpsDevice')
		->join('cars', 'cars.deviceId = gpsDevice.deviceId')
		->queryAll();
		// $rsRegNoPlusDevice = $query->createCommand();
		// $rsRegNoPlusDevice = $command->queryAll();	
		// $rsRegNoPlusDevice = GpsDevice::model()->findAllBySql($sql);
		$carRegNoArray = array('' => '');
		// print_r($rsRegNoPlusDevice);
		foreach ($rsRegNoPlusDevice as $row) {
			$carRegNoArray[$row['phoneNumber'] . '|' . $row['regNo']] = $row['regNo'];

		}

		$this->render('index', array(
			'carsDropDownArray' => $carRegNoArray
			));
	}

	public function actionGetCarCoords() {
		if (!empty($_POST['phoneNumber'])) {
			$queryArray = explode('|', $_POST['phoneNumber']);
			$phoneNumber = $queryArray[0];
			$carRegNo = $queryArray[1];
			$criteria=new CDbCriteria;
			$criteria->select='coordinates, eventTime';  // only select the 'title' column
			$criteria->condition='phoneNumber=:phoneNo';
			$criteria->order='eventTime ASC';
			$criteria->params=array(':phoneNo' => $phoneNumber);
			$rsDeviceCoords = TrackingInfo::model()->findAll($criteria);
			// print_r($deviceCoords);
			$coordsArray = array();
			$coordsArray['carRegNo'] = $carRegNo;
			$coordSearch = array();
			$coordReplace = array();
			$coordsArray['marker'] = array('type' => 'FeatureCollection', 
				'features' => array()
				);
			$bounds = "[";
			$lineString = "[";
			$coordTotal = count($rsDeviceCoords);
			$coordCount = 1;
			foreach ($rsDeviceCoords as $coordKey => $coordVal) {
				// print_r($originalCoords); die();
				$coordsTemp = explode(',', $coordVal['coordinates']);
				$originalCoords = round($coordsTemp[0], 4) . ',' . round($coordsTemp[1], 4);
				$coordVal['coordinates'] = round($coordsTemp[1], 4) . ',' . round($coordsTemp[0], 4);
				$coordsArray['marker']['features'][] = array(
					'type' => 'Feature',
					"properties" => array("popupContent" => "<b> <u>$carRegNo</u> <br/>The car was here at: " . $coordVal['eventTime'] . "</b>"),
					"geometry" => array( 
						"type" => "Point", 
						"coordinates" => array($coordVal['coordinates'])
						));
				$coordSearch[$coordKey] = '"' . $coordVal['coordinates'] . '"';
				$coordReplace[$coordKey] = str_replace(array("+0", "-0"), array("", "-"), $coordVal['coordinates']);
				$bounds .= "[$originalCoords]"; // $coordReplace[$coordKey]; //$coordVal['coordinates'];
				$lineString .= '[' . $coordVal['coordinates'] . ']';
				$bounds .= ($coordCount < $coordTotal) ? ',' : '';
				$lineString .= ($coordCount < $coordTotal) ? ',' : '';
				$coordCount++;
				// $coordsArray['marker'][$coordKey]['popup'] = $coordVal['eventTime'];
			}
			$bounds .= "]";
			$lineString .= "]";
			// var_dump($coordsArray); die();
			// $coordsArray['bounds'] = json_encode($coordReplace, JSON_NUMERIC_CHECK);
			// $coordsArray['bounds'] = str_replace(array('"[',']"'), array('[[',']]'), $coordsArray['bounds']);
			// $coordsArray['bounds']= str_replace('"', '', str_replace('"', '', $coordsArray['bounds']));
			$coordsJson = json_encode($coordsArray, JSON_NUMERIC_CHECK);
			$coordsJson = str_replace($coordSearch, $coordReplace, $coordsJson);
			$trimmedCoordsJson = rtrim($coordsJson, "}");

			echo $trimmedCoordsJson . '}, "bounds": ' . $bounds . ', "lines": ' . $lineString . '}';
			return;
		}
		echo json_encode(array("error" => "There was a problem retrieving GPS coordinates"));
		return;

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = 'login';

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(array('site/index'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}