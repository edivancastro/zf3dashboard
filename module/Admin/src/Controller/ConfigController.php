<?php
namespace Admin\Controller;

use Admin\Service\ConfigService;
use Admin\Model\Config;

class ConfigController extends ControllerAbstract{

	public function indexAction(){
		$service = $this->serviceManager->get(ConfigService::class);

		$config = $service->get();

		if(empty($config)){
			$config = new Config();
			$config->setId(1);
		}

		if($this->request->isPost()){

			$config->setTitulo($this->request->getPost('titulo'));
			$config->setTags($this->request->getPost('tags'));
			$config->setEmailcontato($this->request->getPost('email'));
			$config->setTelcontato($this->request->getPost('tel'));
			$config->setFusohorario($this->request->getPost('fusohorario'));

			$service->salvar($config);

			$this->redirect()->toRoute('home');
		}

		return [
			'config' => $config
		];
	}
}