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
				$this->log->info('Login efetuado');
				return $this->redirect()->toRoute('home');
			}

			$this->log->alert('Tentativa de login');
			$this->flashMessenger()->addErrorMessage("Usuario ou senha incorretos");
			$this->redirect()->toRoute('login');
		}
		
	}
	

	public function acessonegadoAction(){
	    if(!is_object($this->session->usuario)){$this->redirect()->toRoute('login');}
	}

	public function logoutAction(){
		$authService = $this->serviceManager->get(AuthService::class);
		$authService->logout();
		$this->log->info('Logout realizado');
		$this->redirect()->toRoute('home');
	}
}