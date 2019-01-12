<?php
namespace Admin\Service;

use Admin\Model\Config;

class ConfigService extends ServiceAbstract{

	public function get(){
		return $this->entityManager->getRepository(Config::class)->find(1);
	}

	public function salvar($config){
		$this->entityManager->persist($config);
		$this->entityManager->flush();
		return $this;
	}

}