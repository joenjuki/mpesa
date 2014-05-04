<?php

class TrackingInfoController extends Controller {
	const LOG_CAT = 'Trackinfo';
	public $model;

	public function init() {
		$this->model = new Trackinfo;
	}
	public function actionTrackingInfo() {
		// $this->render('trackingInfo');
		if (!empty($_GET['sender']) && !empty($_GET['text'])) {
			$sender = $_GET['sender'];
			$text = $_GET['text'];
			$transaction = $model->dbConnection->beginTransaction();
			$urlArray = parse_url($text);
			//print_r($urlArray);
			parse_str($urlArray['query'], $getVars);
			//echo date('c'); die();
			try {
			// find and save are two steps which may be intervened by another request
			// we therefore use a transaction to ensure consistency and integrity
				$this->model->phoneNumber = $sender;
				$this->model->text = $text;
				$this->model->coordinates = $getVars['q'];
				$this->model->eventTime = date('c');
			// print_r($model); die();
				$this->model->save();
				$transaction->commit();
			} catch(Exception $e) {
				$transaction->rollback();
				Yii::log("Transaction rolled back: $e", 'error', self::LOG_CAT);
			}

		}
	}

	public function queryDevices() {
		$rsGpsDevices = Yii::app()->db->createCommand()
		->select('gpsDevice.deviceId, gpsDevice.password')
		->from('gpsDevice')
		->join('cars', 'cars.deviceId = gpsDevice.deviceId')
		->queryAll();
		$content = array();
		foreach ($rsGpsDevices as $devKey => $dev) {
			if (!empty($dev['deviceId']) && !empty($dev['phoneNumber'])) {
				$content['deviceId'] = $dev['deviceId'];
				$content['text'] = $dev['phoneNumber'] . 'MAP';
				self::executeKannelSms($content);
				
			}
		}

	}

	/**
	 * _executeTixQuery 
	 * 
	 * @param mixed $url 
	 * @access public
	 * @return void
	 */
	private function executeKannelSms($content) {
		$url = "http://localhost:13013/cgi-bin/sendsms?username=tester&password=foobar&to=" . 
		$content['phoneNumber'] . "&text=" . $content['text'] . "&dlr-mask=31&" . 
		"dlr-url=http%3A%2F%2Flocalhost%2Fsms%2Fdlr.php%3Fmsgid%3D4%26type%3D%25d%26receiver%3D%25p%26reply%3D%25A%26time%3D%25t%26usr%3D%25n%26message%3D%25b%26account%3D%25o";
		/**
		 * Initialize handle and set options
		 */
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 20000);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, 20000);
			// if ($method == "HEAD") {
			// 	curl_setopt($ch, CURLOPT_NOBODY, true);
			// 	curl_setopt($ch, CURLOPT_HEADER, true);
			// }
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			// 	'Connection: close'
			// ));
		/**
		* Execute the request and also time the transaction
		*/
		//log in seconds
		//$start = array_sum(explode(' ', microtime()));
		//log in milliseconds

		$start = array_sum(explode(' ', round( microtime( true ) * 1000 )));
		
		$result = curl_exec($ch);
		//log in milliseconds
		$stop = array_sum(explode(' ', round( microtime( true ) * 1000 )));
		// log in seconds
		//$stop = array_sum(explode(' ', microtime()));
		$totalTime = substr(($stop - $start), 0, 5);

		/*CHECK FOR A CURL ERROR CODE 28, MEANING SERVER IS TAKING TOO LONG TO RESPOND. SEND THIS TO THE errorHandler
		FUNCTION FOUND IN taco.inc.php*/
		// if (curl_errno($ch) == "28") {
		// 	errorHandler(curl_errno($ch));
		// }

		/**
		 * Check for errors
		 */
		if (curl_errno($ch)) {
			$result = 'ERROR -> curl error ' . curl_errno($ch) . ': ' . curl_error($ch);
			Yii::log($result, 'error', self::LOG_CAT);
		} else {
			$returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
			switch ($returnCode) {
				case 200:
					Yii::log("Spent $totalTime ms posting to $url", 'info', self::LOG_CAT);
					break;
				case 400:
					$result = "ERROR -> 400 Bad Request, query Failed";
					Yii::log($result, 'warn', self::LOG_CAT);
					break;
				case 404:
					$result = "ERROR -> 404 Not Found";
					Yii::log($result, 'error', self::LOG_CAT);
					break;
				case 302:
					$result = "ERROR -> 302 Redirect";
					Yii::log($result, 'info', self::LOG_CAT);
					break;
				default:
					$result = "ERROR -> Got $returnCode when trying to send sms";
					Yii::log($result, 'info', self::LOG_CAT);
					break;
			}
		}
		/**
		 * Close the handle
		 */
		curl_close($ch);
		//return $result;
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}