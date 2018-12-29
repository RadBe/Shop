<?php

return [

	'APP_NAME' => 'Lumen',
	'APP_ENV' => 'local',
	'APP_KEY' => 'base64:uc4M3bxQXiO0dlIGBbQTvauYKrA+Dp32xTnSgT8y42Y=',
	'APP_DEBUG' => true,
	'APP_URL' => 'http://localhost',
	'APP_TIMEZONE' => 'Europe/Moscow',

	'LOG_CHANNEL' => 'stack',
	'LOG_SLACK_WEBHOOK_URL' => '',

	'DB_CONNECTION' => 'mysql',
	'DB_HOST' => '127.0.0.1',
	'DB_PORT' => 3306,
	'DB_DATABASE' => 'shop',
	'DB_USERNAME' => 'root',
	'DB_PASSWORD' => '',

	'CACHE_DRIVER' => 'file',
	'DOCTRINE_CACHE' => 'file',
	'QUEUE_CONNECTION' => 'sync',

];
