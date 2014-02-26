<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		// echo Yii::app()->basePath; die();
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// Yii::app()->theme = 'abound';
			$this->layout = '//layouts/login';
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					// echo print_r(Yii::app()->controller->module->returnUrl); die();
					if (Yii::app()->user->returnUrl == '/index.php')
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(array('/site/index'));
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}