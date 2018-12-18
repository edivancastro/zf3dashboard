<?php
namespace Admin\Model;

Use Doctrine\ORM\Mapping as ORM;
use Admin\Role\Role;

/**
 * 
 * @ORM\Entity
 *
 */
class Permissao{
	
	/** 
	 * @ORM\Id;
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */	
	protected $descricao;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Modulo", inversedBy="permissoes")
	 * @ORM\joinColumn(name="Modulo_id", referencedColumnName="id")
	 */
	protected $modulo;
	
	/** 
	 * @ORM\ManyToMany(targetEntity="Admin\Model\Role", mappedBy="permissoes")
	 */
	protected $roles;
	
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
		return $this;
	}
	
	public function setModulo(Modulo $modulo){
		$this->modulo = $modulo;
		return $this;
	}
	
	public function addRole(Role $role){
		$this->roles[] = $role;
		return $this;
	}
	
	public function removeRole(Role $role){
		$this->roles->removeElement($role);
		return $this;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getModulo(){
		return $this->modulo;
	}
	
	public function getRoles(){
		return $this->roles;
	}
	
}