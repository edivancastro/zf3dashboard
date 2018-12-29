<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
*/
class Mensagem{
	/**
	* @ORM\Id
	* @ORM\GeneratedValue
	* @ORM\Column(type="integer")
	*/	
	private $id;

	/**
	* @ORM\Column(type="string")
	*/
	private $assunto;

	/**
	* @ORM\Column(type="string")
	*/
	private $texto;

	/**
	* @ORM\Column(type="datetime")
	*/
	private $dataenvio;
	
	/**
	* @ORM\Column(type="datetime")
	*/
	private $dataleitura;

	/**
	* @ORM\ManyToOne(targetEntity="Admin\Model\Usuario", inversedBy="mensagensenviadas")
	* @ORM\JoinColumn(name="remetente", referencedColumnName="id")
	*/
	private $remetente;

	/**
	 * 
	 * @ORM\ManyToMany(targetEntity="Admin\Model\Usuario", inversedBy="mensagensrecebidas")
	 * @ORM\JoinTable(name="Destinatario_Mensagem", joinColumns={@ORM\joinColumn(name="Mensagem_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\joinColumn(name="Usuario_id", referencedColumnName="id")})
	 */
	private $destinatarios;

	public function __construct(){
		$this->destinatarios = new ArrayCollection();
	}

	public function setId($id){
		$this->id = $id;
		return $this;
	}

	public function setAssunto($assunto){
		$this->assunto = $assunto;
		return $this;
	}

	public function setTexto($texto){
		$this->texto = $texto;
		return $this;
	}

	public function setDataenvio($data){
		$this->dataenvio = $data;
		return $this;
	}

	public function setDataleitura($data){
		$this->dataleitura = $data;
		return $this;
	}

	public function setRemetente($usuario){
		$this->remetente = $usuario;
		return $this;
	}

	public function addDestinatario($usuario){
		$this->destinatarios[] = $usuario;
		return $this;
	}

	public function remDestinatario($usuario){
		$this->destinatarios->removeElement($usuario);
		return $this;
	}

	public function getId(){
		return $this->id;
	}

	public function getAssunto(){
		return $this->assunto;
	}

	public function getTexto(){
		return $this->texto;
	}

	public function getDataenvio(){
		return $this->dataenvio;
	}

	public function getDataleitura(){
		return $this->dataleitura;
	}

	public function getRemetente(){
		return $this->remetente;
	}
	
	public function getDestinatarios(){
		return $this->destinatarios;
	}
	
	public function isVisualizada(){
        return $this->dataleitura == null ? false: true;	    
	}
}