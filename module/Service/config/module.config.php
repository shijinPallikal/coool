<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonService the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Service\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /service/:controller/:action
            'service' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/service',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => 'service/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
			),
            

            //Add Action
            'add' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/service/add',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action'        => 'add',
                    ),
                ),
            
            ),
            //List Action
            'list' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/service/list',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action'        => 'list',
                    ),
                ),
            
            ),

            //Detailed Listing
            'detailedListing' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/detailedListing[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action' => 'detailedListing'
                    )
                )
            ), 

            //Edit History
            'editHistory' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/editHistory[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action' => 'editHistory'
                    )
                )
            ), 

            //Status change
            'statusChange' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/statusChange[/:id][/:status]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                        'status' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Service\Controller',
                        'controller'    => 'Index',
                        'action' => 'statusChange'
                    )
                )
            ), 


    
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Service\Controller\Index' => 'Service\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'service/index/index' => __DIR__ . '/../view/service/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);