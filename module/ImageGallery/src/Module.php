<?php
namespace ImageGallery;

use ImageGallery\Model\User;
use ImageGallery\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
 {
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ImageGalleryController::class => function($container) {
                    return new Controller\ImageGalleryController(
                        $container->get('ServiceManager')
                    );
                },
            ],
        ];
    }

 }
