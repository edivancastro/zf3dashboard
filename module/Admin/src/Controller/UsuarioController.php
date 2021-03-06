<?php
namespace Admin\Controller;

use Admin\Service\UsuarioService;
use Admin\Service\RoleService;
use Admin\Model\Usuario;
use Admin\Service\AuthService;
use Zend\Captcha\Image as Captcha;


class UsuarioController extends ControllerAbstract{
    	
	public function indexAction(){

		$CurrentPage = $this->request->getQuery('page',null);
	    
		$usuarios = $this->serviceManager->get(UsuarioService::class)->find($this->request->getQuery('busca',null));
		$usuarios->setItemCountPerPage(15);
		$usuarios->setCurrentPageNumber($CurrentPage);
		
		
		return [
				'usuarios' => $usuarios,
				'busca' => $this->request->getQuery('busca',''),
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
				
			$usrService->salvar($usuario);
			$this->flashMessenger()->addSuccessMessage("Registro salvo!");
			$this->log->info("Usuario cadastrado");
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
			$usuario = $usrService->get($this->session->usuario->getId());
		}

		return [
			'usuario' => $usuario,
			'recursos' => $this->serviceManager->get(RoleService::class)->getAllRecursos()
		];
	}
	
	public function editarAction(){
	    $usuario = $this->serviceManager->get(UsuarioService::class)->get($this->session->usuario->getId());
	    
	    if(!$this->permitido($usuario,'user.manager') && (!$this->permitido($usuario,'user.own.manager') || !$usuario->getId()==$this->params('id',$usuario->getId())) ){
	        $this->redirect()->toRoute('acessonegado');
	    }
	    
		$usrService = $this->serviceManager->get(UsuarioService::class);
		$roleService = $this->serviceManager->get(RoleService::class);
		
		if($this->params('id')<>''){
			$usuario = $usrService->get($this->params('id'));
		}else{
		    $usuario = $usrService->get($this->session->usuario->getId());
		}
				
		if($this->request->isPost()){
			$role = $roleService->get($this->request->getPost("funcao"));
				
			$usuario->setNome($this->request->getPost("nome"))
			->setEmail($this->request->getPost("email"))
			->setLogin($this->request->getPost("login"));

			if($this->request->getPost('senha')<>''){
				$usuario->setSenha($this->request->getPost("senha"));
			}

			$usuario->setRole($role);
		
			$usrService->salvar($usuario);
			$this->flashMessenger()->addSuccessMessage("Registro salvo!");
			$this->log->info("Cadastro de usuario alterada");
			$this->redirect()->toRoute("usuario");
		}
		
		return[
				'usuario' =>$usuario,
				'funcoes' => $roleService->getAll(),
		];
	}

	public function desativarAction(){
		$captcha = new Captcha();

		if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
			$this->serviceManager->get(UsuarioService::class)->desativar($this->params("id"));
			$this->flashMessenger()->addSuccessMessage("Conta desativada!");
			$this->log->info("Conta de usuario desativada");
			$this->redirect()->toRoute("usuario");
		}			

		$captcha->setDotNoiseLevel(10)
				->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
				->setLineNoiseLevel(0);
		
		$id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
		
		return ['captcha'=>$id,
				'usuario'=>$this->serviceManager->get(UsuarioService::class)->get($this->params("id"))
			];
	}
	

	public function delAction(){

		$captcha = new Captcha();

		if($this->request->isPost() && $captcha->isValid($this->request->getPost('captcha'))){
			$this->serviceManager->get(UsuarioService::class)->remover($this->params("id"));
			$this->flashMessenger()->addSuccessMessage("Registro excluido!");
			$this->log->alert("Conta de usuario excluida");
			$this->redirect()->toRoute("usuario");
		}			

		$captcha->setDotNoiseLevel(10)
				->setImgDir(realpath(ROOT_PATH.'/public/temp/captcha'))
				->setLineNoiseLevel(0);
		
		$id = $captcha->setFont(ROOT_PATH.'/public/fonts/arial.ttf')->generate();
		
		return ['captcha'=>$id,
				'usuario'=>$this->serviceManager->get(UsuarioService::class)->get($this->params("id"))
			];
			
	}
	
}