<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Cache\Storage\Adapter\Filesystem;

return [
		// Session configuration.
		'session_config' => [
				// Session cookie will expire in 1 hour.
				'cookie_lifetime' => 60*60*1,
				// Session data will be stored on server maximum for 30 days.
				'gc_maxlifetime'     => 60*60*24*30,
		],
		// Session manager configuration.
		'session_manager' => [
				// Session validators (used for security).
				'validators' => [
						RemoteAddr::class,
						HttpUserAgent::class,
				]
		],
		// Session storage configuration.
		'session_storage' => [
				'type' => SessionArrayStorage::class
		],

        //banco de dados da aplicação
        'doctrine' => [
            'connection' => [
                'orm_default' => [
                    'driverClass' => Doctrine\DBAL\driver\PDOMysql\Driver::class,
                    'params' => [
                        'host' => 'localhost',
                        'user' => 'root',
                        'password' => '1234',
                        'dbname' => 'sistema',
                        'driverOptions' => [
                            1002 => 'SET NAMES utf8'
                        ]
                    ]
                ]
            ]   
        ],

        //Banco de dados de log
        'db'=> [
            'adapters' =>[
                'Db\Adapter\Log' =>[
                    'driver' => 'PdoMysql',
                    'host' => 'localhost',
                    'user' => 'root',
                    'password' => '1234',
                    'dbname' => 'log'
                ]
            ]
        ],

        'caches' => [
        	'FilesystemCache' => [
            	'adapter' => [
                	'name'    => Filesystem::class,
                	'options' => [
                    	// Store cached data in this directory.
                    	'cache_dir' => './data/cache',
                    	// Store cached data for 1 hour.
                    	'ttl' => 60*60*1 
                	],
            	],
            	'plugins' => [
                	[
                    	'name' => 'serializer',
                    	'options' => [                        
                    	],
                	],
            	],
            ],
        ],
];
