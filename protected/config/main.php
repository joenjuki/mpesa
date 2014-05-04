<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Hyper Track',
	'defaultController' => 'user/login',
	'theme' => 'abound',
	'layout' => 'column2',
	'preload' => array(
			'log',
			'session'
		),
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*'
	),

	'modules'=>array(
		'user'=>array(
			'tableUsers' => 'users',
			'tableProfiles' => 'profiles',
			'tableProfileFields' => 'profiles_fields'
		),
		'rights'=>array(
			'install'=> false
		),
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			'generatorPaths'=>array(
				'bootstrap.gii'
			),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			// 'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'RWebUser',
			'loginUrl'=>array('/user/login'),
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
			// 'returnLogoutUrl' => array('/user/login')
		),
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Authenticated', 'Guest'),
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			// 'showScriptName' => false
		),
		'session' => array(
			'sessionName' => 'hypertracksess',
			'class' => 'CHttpSession',
			//'class' => 'CDbHttpSession',
			'autoStart' => true,
			
			'timeout' => 300,
			//'timeout' => 300,

		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db'
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=cartrackmgt',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error'
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
                   'class'=>'CFileLogRoute',
                   'levels'=>'trace, info, error, warning',
                   //'categories'=>'system.*',
                   'logFile' => 'hypertrack.log',
                   'except' => "system.CModule.*, system.caching.*, system.web.*" 

               ),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);