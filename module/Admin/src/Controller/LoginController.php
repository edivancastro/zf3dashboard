<?php
namespace Admin\Controller;

use Admin\Service\AuthService;

class LoginController extends ControllerAbstract{
	
	public function indexAction(){

		if(is_object($this->session->usuario)){$this->redirect()->toRoute('home');}
		
		$authService = $this->serviceManager->get(AuthService::class);
		
		if($this->request->isPost()){
			$usuario = $this->request->getPost('usuario');
			$senha = $this->request->getPost("senha");
			
			if($authService->login($usuario, $senha)){
				return $this->redirect()->toRoute('home');
			}
			
			return['erro'=>'Usuário e/ou senha incorretos'];
		}
	}
	
	public function logoutAction(){
		$authService = $this->serviceManager->get(AuthService::class);
		$authService->logout();
		$this->redirect()->toRoute('home');
	}
}