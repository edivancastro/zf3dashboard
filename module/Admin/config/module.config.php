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
		    'acessonegado' => [
		        'type' => Literal::class,
		        'options' => [
		            'route' => '/acessonegado',
		            'defaults' => [
		                'controller' => Controller\LoginController::class,
		                'action' => 'acessonegado'
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
		    'msg' => [
		        'type' => Segment::class,
		        'options' => [
		            'route' => '/msg[/:action[/:id]]',
		            'defaults' => [
		                'controller' => Controller\MensagemController::class,
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
					Service\ConfigService::class => Service\Factory\ServiceFactory::class,
					Service\MensagemService::class => Service\Factory\ServiceFactory::class,
			        Service\AuthService::class => Service\Factory\AuthServiceFactory::class,
			        Service\RbacService::class => Service\Factory\RbacServiceFactory::class,
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
	 *Controller Plugins
	 */
    'controller_plugins' => [
        'factories' =>[
            Controller\Plugin\PermissaoPlugin::class => Controller\Plugin\Factory\PermissaoPluginFactory::class,
        ],
        'aliases' => [
            'permitido' => Controller\Plugin\PermissaoPlugin::class,
        ]
    ],

    /*
    * Filtro de acesso
    */
    'filtro' => [
    	'options'=>[
    	    //permissivo ou restritivo
    		'modo'=>'restritivo',
    	],
    	'controllers' => [
    	    Controller\IndexController::class => [
    	        ['actions'=>['index'],'allow'=>'@']
    	    ],
    		Controller\UsuarioController::class => [
    		    ['actions'=>['index','detalhar'], 'allow'=>'@'],
    			['actions'=>['editar'], 'allow'=>'+user.own.manager'],
    			['actions'=>['cadastrar','editar','del','desativar','detalhar'], 'allow'=>'+user.manager'],
    		],
    	    Controller\RoleController::class =>[
    	       ['actions'=>['index','detalhar','cadastrar','editar','del'], 'allow'=>'+role.manager'],
    	    ],
    	    Controller\MensagemController::class => [
    	        ['actions'=>['index','enviadas','write','read','find'], 'allow'=>'+msg.own.manager'],
    	    ],
    	    Controller\ConfigController::class => [
    	        ['actions'=>['index'],'allow'=>'+config.manager']
    	    ],
    	    
    	],
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
		'strategies' => [
			'ViewJsonStrategy',
		]
	],

	/*
	*
	*   View Helpers
	*/

	'view_helpers' => [
		'factories' => [
			View\Helper\Menu::class => InvokableFactory::class,
		    View\Helper\Usuario::class => View\Helper\Factory\Factory::class,
			View\Helper\Msg::class => View\Helper\Factory\Factory::class,
			View\Helper\resumeNome::class => View\Helper\Factory\Factory::class,
		    View\Helper\Permissao::class => View\Helper\Factory\Factory::class,
		],
		'aliases' => [
			'menu' =>	View\Helper\Menu::class,
			'usuario' => View\Helper\Usuario::class,
			'msg' => View\Helper\Msg::class,
			'resumeNome' => View\Helper\resumeNome::class,
		    'permitido' => View\Helper\Permissao::class,
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