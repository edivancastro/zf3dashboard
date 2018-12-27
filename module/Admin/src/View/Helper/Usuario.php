<?php
namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container;

class Usuario extends AbstractHelper{
	protected $usuario;

	public function __construct(){
		$this->session = new Container('Admin\Session');
	}	
	
	public function getUsuario(){
		return $this->session->usuario;
	}

	public function isAutenticado(){
		if(is_object($this->session->usuario)){
			return true;
		}
		return false;
	}
}