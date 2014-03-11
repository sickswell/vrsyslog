<?php
// This is the main Web application configuration.

$config_file = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vrsyslog.ini';
if (file_exists($config_file)) {
	$config = parse_ini_file($config_file);
}

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'vrsyslog',
	'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'),
    ),
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'bootstrap.helpers.TbHtml',
		'bootstrap.helpers.TbArray',
	),
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'db'=>array(
			'connectionString' => $config['DB_type'].':host='.$config['DB_host'].';dbname='.$config['DB_name'],
			'emulatePrepare' => true,
			'username' => $config['DB_user'],
			'password' => $config['DB_password'],
			'charset' => 'utf8',
		),
		'bootstrap'=>array(
            'class'=>'bootstrap.components.TbApi',
        ),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
	),
	'params'=>array(
		'adminEmail'=>'codermaverick@gmail.com',
		'TBL_name'=> $config['Table_name'],
		'WEB_user'=> $config['WEB_user'],
		'WEB_password'=> $config['WEB_password'],
	),
);