<?php
namespace Admin\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Admin\Service\Logger;

class LoggerServiceFactory implements FactoryInterface{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null){
       
        //config/autoload/global.php
        $adapter = $container->get('Db\Adapter\Log');

        $mapping = [
            'timestamp'=>'date',
            'priority'=>'type',
            'priorityName'=>'priority',
            'message'=>'event',
            'extra' => ['request'=>'request',
                        'method'=>'method',
                        'post'=>'post',
                        'headers'=>'headers',
                        'userip'=>'userip',
                        'userlogin'=>'userlogin',
                        'userid'=>'userid']
        ];

        $writer = new \Zend\Log\Writer\Db($adapter, 'sistema', $mapping);
        $writer->setFormatter(new \Zend\Log\Formatter\Db('Y-m-d H:i:s'));
        $logger = new \Zend\Log\Logger();

        $logger->addWriter($writer);

        $request = $container->get('Request');

        return new Logger($logger, $request);

	}
	
}