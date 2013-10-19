<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	'layout'=>'/layouts/main',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.PHPExcel.PHPExcel.Classes.*',
	),

	'modules'=>array(
		'admin' => array(
                'globalsalt' => 'Administrative salt', // Глобальная соль для всего модуля (используется в модели AdmUsers)
                'default_route'   => array('url' => 'default/loadfile', 'params' => array('' => '')),
                'site_views_path' => 'admin',
                'components' => array(
                    'adminUser' => array(
                        'allowAutoLogin' => true,
                        'class'          => 'AdminWebUser',
                        'loginUrl'       => array('admin'),
                        'guestName'      => 'Гость',
                    )
                ),
                // Для кастомных действий есть настройки перенаправления действий
                // Все условия должны выполняться, в данном примере - параметр model должен быть равен "resume"
                // И запрошенное действие должно быть "list"
                'actions_map' => array(
                    'loadfile' => array(
                        'condition' => array(
                            //'params' => '',//array('model' => 'resume'),
                            'action' => 'loadfile'
                        ),
                        'action' => 'application.components.actions.loadFile'
                    ),
                    'lingvoleo' => array(
                        'condition' => array(
                            //'params' => '',//array('model' => 'resume'),
                            'action' => 'lingvoleo'
                        ),
                        'action' => 'application.components.actions.lingvoleo'
                    )
                )
            ),
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('192.168.0.*','::1'),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
				'admin'                                  => 'admin/default/index',
				'admin/<model:\w+>'                      => 'admin/default/list',
				'admin/<model:\w+>/<id:\d+>'             => 'admin/default/show',
				'admin/<model:\w+>/create'               => 'admin/default/create',
				'admin/<model:\w+>/update/<id:\d+>'      => 'admin/default/update',
				'admin/<model:\w+>/delete/<id:\d+>'      => 'admin/default/delete',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/drive.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
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