<?php
namespace Admin\Service;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role as RbacRole;
use Admin\Model\Usuario;
use Admin\Model\Role;
use Admin\Model\Permissao;
use Admin\Model\Recurso;


class RbacManager extends ServiceAbstract{
	
	/*
	* @var Zend\Permissions\Rbac\Rbac;
	*/
	protected $rbac;

	/*
	* @var Zend\Cache\Storage\StorageInterface;
	*/
	protected $cache

	/*
	* @var Array;
	*/
	protected $assertionsManager=[];


	public function __contruct($entityManager, StorageInterface $cache, array $assertions){
		parent::construct($entityManager);
		$this->cache = $cache;
		$this->assertionsManager = $assertionsManager;
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
     * @param User|null $user
     * @param string $permission
     * @param array|null $params
     */

	public function isGranted($user, $permission, $params = null)
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
        

        if ($this->rbac->isGranted($role->getName(), $permission)) {

        	if ($params==null)
        		return true;

        	foreach ($this->assertionManagers as $assertionManager) {
        		if ($assertionManager->assert($this->rbac, $permission, $params))
        			return true;
        	}
        }
        
        return false;
    }
    
}