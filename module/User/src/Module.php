<?php
namespace User;

use User\Model\User;
use User\Model\UserRepository;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;

class Module
 {
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'User\Model\UserRepository' =>  function($sm) {
                     $tableGateway = $sm->get('UserTableGateway');
                     $table = new UserRepository($tableGateway);
                     return $table;
                 },
                 'UserTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new User());
                     return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

     /**
     * This method is called once the MVC bootstrapping is complete. 
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        
        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one.
        $sessionManager = $serviceManager->get(SessionManager::class);
    }
 }
?>