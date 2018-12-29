<?php
namespace Admin;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

/*
 * Rotas
 */
return [ 
	'router' => [
		'routes' => [
			'home' => [
				'type' => Literal::class,
				'options' => [
					'route' => '/',
					'defaults' => [
						'controller' => Controller\IndexController::class,
						'action' => 'index'
					]
				]
			],
			'login' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/login[/:action]',
					'defaults' => [
						'controller' => Controller\LoginController::class,
						'action' => 'index'
					]
				]
			],
			'usuario' => [
					'type' => Segment::class,
					'options' => [
							'route' => '/usuario[/:action[/id/:id]]',
							'defaults' => [
									'controller' => Controller\UsuarioController::class,
									'action' => 'index'
							]
					]
			],
			'role' => [
					'type' => Segment::class,
					'options' => [
							'route' => '/role[/:action[/id/:id]]',
							'defaults' => [
									'controller' => Controller\RoleController::class,
									'action' => 'index'
							]
					]
			],
			'config' => [
					'type' => Literal::class,
					'options' => [
							'route' => '/config',
							'defaults' => [
									'controller' => Controller\ConfigController::class,
									'action' => 'index'
							]
					]
			],
		    'msg-inbox' => [
		        'type' => literal::class,
		        'options' => [
		            'route' => '/msg',
		            'defaults' => [
		                'controller' => Controller\MensagemController::class,
		                'action' => 'index'
		            ]
		        ]
		    ],
		    'msg-enviadas' => [
		        'type' => literal::class,
		        'options' => [
		            'route' => '/msg/enviadas',
		            'defaults' => [
		                'controller' => Controller\MensagemController::class,
		                'action' => 'enviadas'
		            ]
		        ]
		    ],
		    'msg-read' => [
		        'type' => Segment::class,
		        'options' => [
		            'route' => '/msg/read/:id',
		            'defaults' => [
		                'controller' => Controller\MensagemController::class,
		                'action' => 'read'
		            ]
		        ]
		    ],
		    'msg-write' => [
		        'type' => Segment::class,
		        'options' => [
		            'route' => '/msg/write',
		            'defaults' => [
		                'controller' => Controller\MensagemController::class,
		                'action' => 'write'
		            ]
		        ]
		    ],
		]
	],
	
	/*
	 * Service Manager factories
	 */
	'service_manager' => [
			'factories' => [
					Service\AuthService::class => Service\Factory\ServiceFactory::class,
					Service\UsuarioService::class => Service\Factory\ServiceFactory::class,
					Service\RoleService::class => Service\Factory\ServiceFactory::class,
					Service\ConfigService::class => Service\Factory\ServiceFactory::class,
					Service\MensagemService::class => Service\Factory\ServiceFactory::class,
			]
	],
		
	/*
	 * Controllers factories
	 */
	'controllers' => [
		'factories' => [
			Controller\IndexController::class => Controller\Factory\ControllerAbstractFactory::class,
			Controller\LoginController::class => Controller\Factory\ControllerAbstractFactory::class,
			Controller\UsuarioController::class => Controller\Factory\ControllerAbstractFactory::class,
			Controller\RoleController::class => Controller\Factory\ControllerAbstractFactory::class,
			Controller\ConfigController::class => Controller\Factory\ControllerAbstractFactory::class,
			Controller\MensagemController::class => Controller\Factory\ControllerAbstractFactory::class,

		]
	],
    
		
	/*
	 * View 
	 */
	'view_manager' => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => [
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack' => [
				__DIR__ . '/../view',
		],
	],

	/*
	*
	*   View Helpers
	*/

	'view_helpers' => [
		'factories' => [
			View\Helper\Menu::class => InvokableFactory::class,
			View\Helper\Usuario::class => InvokableFactory::class
		],
		'aliases' => [
			'menu' =>	View\Helper\Menu::class,
			'usuario' => View\Helper\Usuario::class,
		]
	],
	
	/*
	 * Doctrine Annotation Driver
	 */
	'doctrine' => [
		'driver' => [
				__NAMESPACE__.'_driver' => [
						'class' => AnnotationDriver::class,
						'cache' => 'array',
						'paths' => [
							__DIR__.'/../src/Model',
						]
				],
				'orm_default' =>[
					'drivers' => [
						__NAMESPACE__.'\Model' => __NAMESPACE__.'_driver'
					]
				]
		]
	]
];