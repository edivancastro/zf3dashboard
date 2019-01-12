<?php
namespace Admin\View;

use Zend\View\Renderer\PhpRenderer;

class Renderer extends PhpRenderer{
    
    protected $encoding;
    
    public function __construct($encoding){
        parent::__construct();
        $this->encoding = $encoding;
    }
    
    public function setEncoding($encoding){
        $this->encoding = $encoding;
    }
    
    public function getEncoding(){
        return $this->encoding;
    }
    
}