<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
* @ORM\Entity
*/
class Mensagem implements \JsonSerializable{
	const INBOX=1;
	const OUTBOX=2;

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
	* @ORM\ManyToOne(targetEntity="Admin\Model\Usuario", inversedBy="mensagensenviadas")
	* @ORM\JoinColumn(name="remetente", referencedColumnName="id")
	*/
	private $remetente;

	/**
	 * @ORM\OneToMany(targetEntity="Admin\Model\DestinatarioMensagem", mappedBy="mensagem", cascade={"all"})
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

	public function setRemetente($usuario){
		$this->remetente = $usuario;
		return $this;
	}

	public function addDestinatarioMensagem(DestinatarioMensagem $destinatario){
		$destinatario->setMensagem($this);
		$this->destinatarios[] = $destinatario;
		return $this;
	}

	public function remDestinatarioMensagem(DestinatarioMensagem $destinatario){
		$this->destinatarios->removeElement($destinatario);
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

	public function getRemetente(){
		return $this->remetente;
	}
	
	public function getDestinatarioMensagem(){
		return $this->destinatarios;
	}
	
	public function jsonSerialize(){
		$vars = get_object_vars($this);
        return $vars;
	}

}