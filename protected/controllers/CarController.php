<?php

class carController extends Controller {
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
		$connection = Yii::app()->db;
		$sql = 'SELECT * FROM `cars`';
		$command = $connection->createCommand($sql);
		$dataReader = $command->queryAll();
		// calling read() repeatedly until it returns false
		$carArray = array();
		if (!empty($dataReader)) {
			foreach ($dataReader as $row) {
				$carArray[] = $row;
			}
		}
		$carJson = json_encode($carArray);
		$this->render('index', array(
			'carJson' => $carJson
			));
	}

	public function actionAddCar() {
		$model = new CarForm();
		$params = array();
		// print_r($_POST['CarForm']); die();
		if (empty($_POST['CarForm'])) {
			$connection = Yii::app()->db;
			$sql = "SELECT `deviceId` 
			FROM `gpsDevice`
			WHERE NOT EXISTS 
			(SELECT `deviceId` 
                  FROM `cars`
                  WHERE cars.deviceId = gpsDevice.deviceId)";
			$command = $connection->createCommand($sql);
			$dataReader = $command->query();
			$params['devicesArray'] = array();
			foreach ($dataReader as $result) {
				$params['devicesArray'][$result['deviceId']] = $result['deviceId'];
			}
			$params['usersArray'] = $this->getUsers();
			$this->render('addCar', array(
				'model' => $model,
				'params' => $params
				), false, true
			);
			return;

		}
		if (!empty($_POST['CarForm'])) {
			$model->attributes = $_POST['CarForm'];
			$connection = Yii::app()->db;
			$sql = "INSERT INTO `cars` (regNo, deviceId, ownerId, make, model)
			VALUES ( '$model->regNo', '$model->deviceId', '$model->ownerId', '$model->make', '$model->model')";
			$command = $connection->createCommand($sql);
			$execResult = $command->execute();
			if($execResult) {
				Yii::app()->user->setFlash('success', "Vehicle - $model->regNo - added successfuilly");
				$this->redirect(array('index'));
				return;
			}
			echo "There was an error adding the vehicle";
		}

	}

	public function actionEditCar() {
		$model = new CarForm();
		$params = array();
		if (!empty($_POST['editCarReg'])) {
			$carId = $_POST['editCarReg'];
			$connection = Yii::app()->db;
			$sql = "SELECT * FROM `cars` WHERE `regNo` = '$carId'";
			$command = $connection->createCommand($sql);
			$dataReader = $command->query();
			foreach ($dataReader as $row) {
				$model->attributes = $row;
			}
			$sql = "SELECT `deviceId` FROM gpsDevice";
			// $connection = Yii::app()->db;
			$command = $connection->createCommand($sql);
			$dataReader = $command->query();
			$params['devicesArray'] = array();
			foreach ($dataReader as $row) {
				$params['devicesArray'][$row['deviceId']] = $row['deviceId'];
			}
			$params['usersArray'] = array();
			$params['usersArray'] = $this->getUsers();
			
			// print_r($usersArray);
			$this->render('editCar', array(
				'model' => $model,
				'params' => $params
				));

		}

	}
	/**
	* getUsers
	* @return array
	*/
	private function getUsers() {
		$connection = Yii::app()->db;
		$sql = "SELECT `id`, `username` FROM users";
		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$usersArray = array();
		foreach ($dataReader as $row) {
			$usersArray[$row['id']] = $row['username'];
		}
		// print_r($usersArray); die();
		return $usersArray;
	}
}
