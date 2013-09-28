<?php

class MpesaController extends Controller {
	const LOGCAT = 'mpesa-controller';

	public function actionTestMpesa() {
		$referer = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
		Yii::log($referer, 'info', self::LOGCAT);
		$this->render('testMpesa');

	}
}