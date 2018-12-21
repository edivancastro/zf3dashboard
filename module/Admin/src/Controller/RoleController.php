<?php
namespace Admin\Controller;

use Admin\Service\RoleService;

class RoleController extends ControllerAbstract{
	
	public function indexAction(){
		return[
		    'funcoes' => $this->serviceManager->get(RoleService::class)->getAll(),
		];
	}
	
	public function cadastrarAction(){
	    
	}
	
	public function editarAction(){
	    
	}
	
	public function delAction(){
	    
	}
}