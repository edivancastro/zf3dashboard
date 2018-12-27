<?php
namespace Admin\Controller;

use Admin\Service\UsuarioService;
use Admin\Service\RoleService;
use Admin\Model\Usuario;
use Admin\Service\AuthService;

class UsuarioController extends ControllerAbstract{
    	
	public function indexAction(){
	    
		$usrService = $this->serviceManager->get(UsuarioService::class);
		
		return [
				'usuarios' => $usrService->getAll(),
		];
	}
	
	public function cadastrarAction(){
		$usrService = $this->serviceManager->get(UsuarioService::class);
		$roleService = $this->serviceManager->get(RoleService::class);
		
		if($this->request->isPost()){
			$role = $roleService->get($this->request->getPost("funcao"));
			
			$usuario = new Usuario();
			$usuario->setNome($this->request->getPost("nome"))
			->setEmail($this->request->getPost("email"))
			->setLogin($this->request->getPost("login"));
			
			if($this->params('senha')<>''){
				$usuario->setSenha($this->params('senha'));
			}
			
			$usuario->setRole($role);
				
			$usrService->cadastrar($usuario);
			$this->redirect()->toRoute("usuario");
		}
		
		return[
			'funcoes' => $roleService->getAll(),	
		];
	}

	public function detalharAction(){
		$usrService = $this->serviceManager->get(UsuarioService::class);

		if($this->params('id')<>''){
			$usuario = $usrService->get($this->params('id'));
		}else{
			$session = $this->serviceManager->get(AuthService::class)->getUser();
			$usuario = $usrService->get($session->getId());
		}

		return [
			'usuario' => $usuario,
			'recursos' => $this->serviceManager->get(RoleService::class)->getAllRecursos()
		];
	}
	
	public function editarAction(){
		$usrService = $this->serviceManager->get(UsuarioService::class);
		$roleService = $this->serviceManager->get(RoleService::class);
		
		if($this->params('id')<>''){
			$usuario = $usrService->get($this->params('id'));
		}else{
			$session = $this->serviceManager->get(AuthService::class)->getUser();
			$usuario = $usrService->get($session->getId());
		}
				
		if($this->request->isPost()){
			$role = $roleService->get($this->request->getPost("funcao"));
				
			$usuario->setNome($this->request->getPost("nome"))
			->setEmail($this->request->getPost("email"))
			->setLogin($this->request->getPost("login"))
			->setSenha($this->request->getPost("senha"));
			$usuario->setRole($role);
		
			$usrService->cadastrar($usuario);
			$this->redirect()->toRoute("usuario");
		}
		
		return[
				'usuario' =>$usuario,
				'funcoes' => $roleService->getAll(),
		];
	}
	

	public function delAction(){
		$this->serviceManager->get(UsuarioService::class)->remover($this->params("id"));
		$this->redirect()->toRoute("usuario");		
	}
	
}