<?php
namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

Class Data extends AbstractHelper{
    protected $data;
    
    public function __invoke(\DateTime $data=null){
        if(!is_object($data)){
            $this->data = new \DateTime();
        }else{
            $this->data = $data;
        }
        return $this;
    }
    
    public function getLiteral(){
        return $this->dia().", ".$this->data->format('d')." de ".$this->mes()." de ".$this->data->format('Y').', às '.$this->data->format('H:i');
    }
    
    public function getDateTime(){
        return $this->data->format('d/m/Y H:i');
    }
    
    public function getDate(){
        return $this->data->format('d/m/Y');
    }
    
    protected function dia(){
        $dia[0] = 'Domingo';
        $dia[1] = 'Segunda-feira';
        $dia[2] = 'Terça-feira';
        $dia[3] = 'Quarta-feira';
        $dia[4] = 'Quinta-feira';
        $dia[5] = 'Sexta-feira';
        $dia[6] = 'Sábado';
        
        return $dia[$this->data->format('w')];
    }
    
    protected function mes(){
        $Mes[1]  = 'Janeiro';
        $Mes[2]  = 'Fevereiro';
        $Mes[3]  = 'Março';
        $Mes[4]  = 'Abril';
        $Mes[5]  = 'Maio';
        $Mes[6]  = 'Junho';
        $Mes[7]  = 'Julho';
        $Mes[8]  = 'Agosto';
        $Mes[9]  = 'Setembro';
        $Mes[10] = 'Outubro';
        $Mes[11] = 'Novembro';
        $Mes[12] = 'Dezembro';
        
        return $Mes[$this->data->format('n')];
    }
    
}