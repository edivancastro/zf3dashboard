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
			'funcao' => [
					'type' => Segment::class,
					'options' => [
							'route' => '/funcao[/:action[/id/:id]]',
							'defaults' => [
									'controller' => Controller\FuncaoController::class,
									'action' => 'index'
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
			Controller\FuncaoController::class => Controller\Factory\ControllerAbstractFactory::class,

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