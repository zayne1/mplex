<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Metroplex Multimedia Streaming App',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.mongo.*',
	),
	'aliases' => array(
        'xupload' => 'ext.xupload',        
    ),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','192.168.1.*','192.168.56.*','192.168.8.*'),
			'generatorPaths'=>array(
	            'ext.mongo.gii'
	        ),
		),
		'admin',
		'backend',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'mongodb' => array(
	        'class'             => 'EMongoDB',
	        'connectionString'  => 'mongodb://localhost',
	        // 'connectionString'  => 'mongodb://192.168.56.101',
	        'dbName'            => 'test',
	        'fsyncFlag'         => false,
	        'safeFlag'          => false,
	        'useCursor'         => false,
	    ),
	    'zutils' => array(
            'class' => 'application.components.ZUtils',
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',


				'<module:admin>/'    =>'admin/default/index',
                '<module:admin>/index'    =>'admin/default/index',
                '<module:admin>/<action>'=>'admin/default/<action>',

                '<module:backend>/upload/'=>'backend/upload/', // id as word, eg uuid

				'<module:backend>/'    =>'backend/default/index',
                '<module:backend>/index'    =>'backend/default/index',
                '<module:backend>/<action>'=>'backend/default/<action>',

                '<module:backend>/organization/<action>'=>'backend/organization/<action>',
                '<module:backend>/organization/id/'=>'backend/organization/view', // id as word, eg uuid
                '<module:backend>/event/<action>'=>'backend/event/<action>',
                '<module:backend>/event/id/'=>'backend/event/view', // id as word, eg uuid
                '<module:backend>/video/<action>'=>'backend/video/<action>',
                '<module:backend>/video/id/'=>'backend/video/view', // id as word, eg uuid
                '<module:backend>/user/<action>'=>'backend/user/<action>',
                '<module:backend>/user/id/'=>'backend/user/view', // id as word, eg uuid
                
                // '<module:cms>/upload/'=>'cms/upload/',
                    


                '/'=>'site/index',
                '<action>'=>'site/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/setZippingStatus/status/'=>'<controller>/setZippingStatus',
				// defaults to a site page if not above
                '<view:[a-zA-Z0-9-]+>/'=>'site/page',
                    
			),
		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=metroplex',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'ert123iop',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'session' => array (
			'sessionName' => 'SiteAccess',
			'cookieMode' => 'only',
			// 'savePath' => '/path/to/new/directory',
			'timeout' => 315360000,
			'cookieParams'=>array(
                'domain' => $_SERVER['SERVER_NAME'],
                'expire' => time()+60*60*24*180,
            ),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'info@metroplex.com',
	),
);