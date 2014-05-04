<?php

class CarsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl' // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow authenticated users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('admin'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Cars;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$dropDownData = array();
		$dropDownData = $this->getDropDownData();
		if(isset($_POST['Cars']))
		{
			$model->attributes=$_POST['Cars'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', 'Car ' . $_POST['Cars']['regNo'] . ' has been successfully added');
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model' => $model,
			'dropDownData' => $dropDownData
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()	{
		$id = empty($_GET['id']) ? '' : $_GET['id'];
		$model = $this->loadModel($id);
		$dropDownData = $this->getDropDownData(true);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cars']))
		{
			$carProperties = $_POST['Cars'];
			$model->attributes = $carProperties;
			if($model->save())
				Yii::app()->user->setFlash('success', 'Car ' . $carProperties['regNo'] . ' has been successfully updated');
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
			'dropDownData' => $dropDownData
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete() {
		if(Yii::app()->user->checkAccess('Cars.delete')) {
			$id = empty($_GET['id']) ? '' : $_GET['id'];
			//$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Car ' . $id . ' has been successfully removed');

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$rsCars = Yii::app()->db->createCommand()
				->select('cars.regNo, cars.deviceId, cars.ownerId, cars.model, cars.make, users.username')
				->from('cars')
				->join('users', 'cars.ownerId = users.id')
				->queryAll();

		$carsArray = array();
		foreach ($rsCars as $carKey => $car) {
			$carsArray[$carKey]['regNo'] = $car['regNo'];
			$carsArray[$carKey]['deviceId'] = $car['deviceId'];
			$carsArray[$carKey]['make'] = $car['make'];
			$carsArray[$carKey]['model'] = $car['model'];
			$carsArray[$carKey]['ownerId'] = $car['username'];
		}
		// print_r($carsArray); die();
		$this->render('index',array(
			'carsArray' => $carsArray,
		));
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cars('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cars']))
			$model->attributes=$_GET['Cars'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	private function getDropDownData($update = false) {
		$dropDownData['owners'][''] = '';
		$dropDownData['devices'][''] = '';
		$rsOwners = Yii::app()->db->createCommand()
		->select('id, username')
		->from('users')
		->queryAll();
		// print_r($rsOwners); die();
		foreach ($rsOwners as $ownerKey => $ownerData) {
			$dropDownData['owners'][$ownerData['id']] = $ownerData['username'];
		}
		// get all devices that are not in use
		$condition = 'deviceId NOT IN (SELECT deviceId FROM cars)';
		if ($update) {
			$condition = 'deviceId IN (SELECT deviceId FROM cars)';
		}
		$rsDevices = Yii::app()->db->createCommand()
		->select('deviceId')
		->from('gpsDevice')
		->where($condition)
		->queryAll();
		// print_r($rsDevices); die();
		foreach ($rsDevices as $devKey => $devData) {
			$dropDownData['devices'][$devData['deviceId']] = $devData['deviceId'];
		}
		return $dropDownData;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cars the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cars::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cars $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cars-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
