<?php
namespace Admin\Controller;

use Admin\Service\RoleService;
use Admin\Model\Role;
use Admin\Model\Permissao;
use Zend\View\Model\ViewModel;
use Zend\Captcha\Image as Captcha;

class RoleController extends ControllerAbstract{
	
	public function indexAction(){
		return[
		    'funcoes' => $this->serviceManager->get(RoleService::class)->getAll(),
		];
	}
	
	public function cadastrarAction(){
	    if($this->request->isPost()){
	        $role = new Role();
	        $role->setDescricao($this->request->getPost('descricao'));
	        
	        if($this->request->getPost('root')=='*'){
	            $role->setRoot(true);
	        }else{
	            $role->setRoot(false);
	            
	            foreach($this->request->getPost('permissao') as $idPermissao){
	                $permissao = $this->serviceManager->get(RoleService::class)->getPermissao($idPermissao);
	                $role->addPermissao($permissao);
	            }
	        }
	                
	        $this->serviceManager->get(RoleService::class)->cadastrar($role);
	        $this->redirect()->toRoute("role");
	    }
	    
	    return [
	        'recursos' => $this->serviceManager->get(RoleService::class)->getAllRecursos(),
	    ];
	}
	
	public function editarAction(){
	    $role = $this->serviceManager->get(RoleService::class)->get($this->params('id'));

	    if(!is_object($role)){
	    	$this->redirect()->toRoute("role");
	    }
	    
	    if($this->request->isPost()){
	        $role->setDescricao($this->request->getPost('descricao'));
	        
	        if($this->request->getPost('root')=='*'){
	            $role->setRoot(true);
	            $role->getPermissoes()->clear();
                
	        }else{
	            $role->setRoot(false);
	            
	            foreach($this->request->getPost('permissao') as $idPermissao){
	                $permissao = $this->serviceManager->get(RoleService::class)->getPermissao($idPermissao);
	                if(!$role->getPermissoes()->contains($permissao)){
	                   $role->addPermissao($permissao);
	                }
	            }
	        }
	        
	        $this->serviceManager->get(RoleService::class)->cadastrar($role);
	        $this->redirect()->toRoute("role");
	    }
	    
	    return [
	        'role' => $role,
	        'recursos' => $this->serviceManager->get(RoleService::class)->getAllRecursos(),
	    ];
	}
	
	public function detalharAction(){
	    $view = new ViewModel([
	        'role' => $this->serviceManager->get(RoleService::class)->get($this->params('id')),
	        'recursos' => $this->serviceManager->get(RoleService::class)->getAllRecursos(),
	    ]);
	    return $view;
	}
	
	public function delAction(){
		$captcha = new Captcha();

		if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
			$this->serviceManager->get(RoleService::class)->remover($this->params('id'));
	    	$this->redirect()->toRoute('role');
		}			

		$captcha->setDotNoiseLevel(10)
				->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
				->setLineNoiseLevel(0);
		
		$id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
		
		return ['captcha'=>$id,
				'role'=>$this->serviceManager->get(RoleService::class)->get($this->params("id"))
			];
		
	}
	
}