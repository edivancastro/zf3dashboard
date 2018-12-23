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
	 * @ORM\Column(type="string")
	 */
	protected $nome;
	
	/** 
	 * @ORM\ManyToMany(targetEntity="Admin\Model\Role", mappedBy="permissoes")
	 */
	protected $roles;
	
	/**
	 * 
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Recurso", inversedBy="permissoes");
	 * @ORM\joinColumn(name="Recurso_id", referencedColumnName="id");
	 */
	protected $recurso;
	
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
	public function setNome($nome){
	    $this->nome = $nome;
	    return $this;
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
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
	
	public function setRecurso(Recurso $recurso){
	    $this->recurso = $recurso;
	    return $this;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getNome(){
	    return $this->nome;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getRoles(){
		return $this->roles;
	}
	
	public function getRecurso(){
	    return $this->recurso;
	}
	
}