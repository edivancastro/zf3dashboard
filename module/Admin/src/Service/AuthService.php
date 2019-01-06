<?php
namespace Admin\Service;

use Admin\Model\Usuario;
use Doctrine\ORM\EntityManager;

class AuthService extends ServiceAbstract{
    const REQUER_AUTH = -1;
    const ACESSO_NEGADO = 0;
	const ACESSO_PERMITIDO = 1;
	
	/*
	 * @var Array
	 */
    protected $config;
    
    /*
     * @var Admin\Service\RbacManager
     */
    protected $rbacService;
	
	public function __construct(EntityManager $em, $config, $rbacService){
	    parent::__construct($em);
	    $this->config = $config;
	    $this->rbacService = $rbacService;
	}
	
	public function login($usuario, $senha){
		$result = $this->entityManager->createQueryBuilder()
		->select('a')
		->from('Admin\Model\Usuario','a')
		->where('a.login = :usuario')
		->andWhere('a.senha = :senha')
		->andWhere('a.status = :status')
		->setParameter('status',Usuario::STATUS_ATIVO)
		->setParameter('usuario', $usuario)
		->setParameter('senha', $senha)
		->setMaxResults(1)
		->getQuery()->getOneOrNUllResult();
		
		if(!empty($result)){
			$this->entityManager->detach($result);
			$this->session->usuario = $result;
			return true;
		}
		
		return false;
	}
	
	public function logout(){
		return $this->session->getManager()->getStorage()->clear('Admin\Session');
	}
	
	public function filtrar($controllerName, $actionName, Array $params=null)
	{
	   
	    $modo = isset($this->config['options']['modo'])?$this->config['options']['modo']:'restritivo';
	    
	    if ($modo !='restritivo' && $modo!='permissivo'){
	        throw new \Exception('Invalid access filter mode (expected either restrictive or permissive mode');
	    }
	    
	    if (isset($this->config['controllers'][$controllerName])) {
	        
	        $items = $this->config['controllers'][$controllerName];
	        
            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];
                
                if((is_array($actionList) & in_array($actionName,$actionList)) or $actionName=='*'){
                    if ($allow=='*'){
                        return self::ACESSO_PERMITIDO;
                    }else if (!is_object($this->session->usuario)) {
                            return self::REQUER_AUTH;
                    }
                    
                    if ($allow=='@') {
                        
                        // Any authenticated user is allowed to see the page.
                        return self::ACESSO_PERMITIDO;
                        
                    } else if (substr($allow, 0, 1)=='+') {
                        
                        
                        // Only the user with this permission is allowed to see the page.
                        $permission = substr($allow, 1);
              
                        if ($this->rbacService->isGranted(null, $permission, $params)){
                            return self::ACESSO_PERMITIDO;
                        }else{
                            return self::ACESSO_NEGADO;
                        }
                        
                    } else {
                        throw new \Exception('Unexpected value for "allow" - expected ' .
                            'either "*", "@", or "+permission"');
                    }
                }
	        }
	    }
	        
	    //modo restritivo (Somente usuarios autenticados)
	    if ($modo=='restritivo'){
	       return self::ACESSO_NEGADO;
	    }
	    
	   //modo permissivo (qualquer usuario)
	   return self::ACESSO_PERMITIDO;
	}

}