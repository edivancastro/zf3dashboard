<?php
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Admin\Service\MensagemService;
use Zend\Session\Container;

class Msg extends AbstractHelper{
	protected $serviceManager;

	public function __construct($sm){
		$this->serviceManager = $sm;
	}

	public function countNews(){
		return $this->serviceManager->get(MensagemService::class)->getTotalNaoLidas();
	}
}