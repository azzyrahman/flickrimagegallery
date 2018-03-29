<?php
namespace ImageGallery;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    // The image gallery routing:
    'router' => [
        'routes' => [
            'imagegallery' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/imagegallery[/:action[/:id][/:url][/:page]]',
                    'constraints' => [
                        'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'      => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ImageGalleryController::class,
                        'action'     => 'index',
                    ],
                ],
           
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'imagegallery' => __DIR__ . '/../view',
        ],
    ],
];

