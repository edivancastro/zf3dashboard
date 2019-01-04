<?php
namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;

class resumeNome extends AbstractHelper{

	public function __invoke($nome){
		$novonome = explode(' ',$nome);
		$novonome = sizeof($novonome) > 2? array_shift($novonome).' '.array_pop($novonome):$nome;
		return $novonome;
	}
}