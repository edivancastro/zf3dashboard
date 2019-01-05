<?php
namespace Admin\Service;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role as RbacRole;
use Zend\Cache\Storage\StorageInterface;
use Admin\Model\Usuario;
use Admin\Model\Role;
use Admin\Model\Permissao;
use Admin\Model\Recurso;



class RbacService extends ServiceAbstract{
	
	/*
	* @var Zend\Permissions\Rbac\Rbac;
	*/
	protected $rbac;

	/*
	* @var Zend\Cache\Storage\StorageInterface;
	*/
	protected $cache;



	public function __construct($entityManager, StorageInterface $cache){
		parent::__construct($entityManager);
		$this->cache = $cache;
	
	}

	public function init($force=false){
		if($this->rbac !=null && !$force){return;}

		if($force){$this->cache->removeItem('rbac_container');}

		$this->rbac = $this->cache->getItem('rbac_container', $result);

        if (!$result)
        {
            // Create Rbac container.
            $rbac = new Rbac();
            $this->rbac = $rbac;

            // Construct role hierarchy by loading roles and permissions from database.

            $rbac->setCreateMissingRoles(true);

            $roles = $this->entityManager->getRepository(Role::class)
                    ->findBy([], ['id'=>'ASC']);
            foreach ($roles as $role) {

                $roleName = $role->getDescricao();

                $rbac->addRole($roleName);

                foreach ($role->getPermissoes() as $permissao) {
                    $rbac->getRole($roleName)->addPermission($permissao->getNome());
                }
            }
            
            // Save Rbac container to cache.
            $this->cache->setItem('rbac_container', $rbac);
        }
	}

	/**
     * checa permissão de um determinado usuario.
     * @param Usuario|null $user
     * @param string $permission
     * @param array|null $params
     */

	public function isGranted($user, $permission)
    {
        if ($this->rbac==null) {
            $this->init();
        }
        
        if ($user==null) {
            
            $session = $this->session->usuario;

            if ($session==null) {
                return false;
            }
            
            $user = $this->entityManager->getRepository(Usuario::class)
                    ->find($session->getId());

            if ($user==null) {
                throw new \Exception('Usuario não encontrado!');
            }
        }
        
        $role = $user->getRole();
        

        if ($role->isRoot() || $this->rbac->isGranted($role->getDescricao(), $permission)) {
            return true;
        }
        
        return false;
    }
    
    
}