<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class Config{
	/**
	* @ORM\Id
	* @ORM\GeneratedValue
	* @ORM\Column
	*/
	protected $id;
	
	/**
	* @ORM\Column(type="string")
	*/
	protected $titulo;

	/**
	* @ORM\Column(type="string")
	*/
	protected $tags;

	/**
	* @ORM\Column(type="string")
	*/
	protected $emailcontato;

	/**
	* @ORM\Column(type="string")
	*/
	protected $telcontato;

	/**
	* @ORM\Column(type="string")
	*/
	protected $fusohorario = 'DF';

	protected $timezone = [
			'AC' => 'America/Rio_branco',
			'AL' => 'America/Maceio',
			'AP' => 'America/Belem',
			'AM' => 'America/Manaus',
			'BA' => 'America/Bahia',
			'CE' => 'America/Fortaleza',
			'DF' => 'America/Sao_Paulo',
			'ES' => 'America/Sao_Paulo',
			'GO' => 'America/Sao_Paulo',
			'MA' => 'America/Fortaleza',
			'MT' => 'America/Cuiaba',
			'MS' => 'America/Campo_Grande',
			'MG' => 'America/Sao_Paulo',
			'PR' => 'America/Sao_Paulo',
			'PB' => 'America/Fortaleza',
			'PA' => 'America/Belem',
			'PE' => 'America/Recife',
			'PI' => 'America/Fortaleza',
			'RJ' => 'America/Sao_Paulo',
			'RN' => 'America/Fortaleza',
			'RS' => 'America/Sao_Paulo',
			'RO' => 'America/Porto_Velho',
			'RR' => 'America/Boa_Vista',
			'SC' => 'America/Sao_Paulo',
			'SE' => 'America/Maceio',
			'SP' => 'America/Sao_Paulo',
			'TO' => 'America/Araguaia',
	];	

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function setTitulo($titulo){
		$this->titulo = $titulo;
		return $this;
	}

	public function setTags($tags){
		$this->tags = $tags;
		return $this;
	}

	public function setEmailcontato($email){
		$this->emailcontato = $email;
		return $this;
	}

	public function setTelcontato($tel){
		$this->telcontato = $tel;
		return $this;
	}

	public function setFusohorario($fs){
		$this->fusohorario = $fs;
		return $this;
	}

	public function getId(){
		return $this->id;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function getTags(){
		return $this->tags;
	}

	public function getEmailcontato(){
		return $this->emailcontato;
	}

	public function getTelcontato(){
		return $this->telcontato;
	}

	public function getFusohorario(){
		return $this->fusohorario;
	}

	public function getTimezone(){
		return $this->timezone[$this->fusohorario];
	}

}