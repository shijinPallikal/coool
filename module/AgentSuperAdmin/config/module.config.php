<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonsuperadmin for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/*
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Superadmin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /Superdmin/:controller/:action
            'superadmin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/superadmin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Superadmin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),

                    */
return array(
    'router' => array(
        'routes' => array(

                    
 /* ------------------------------------------------------------------------------------------------------------------------------------------ */                   
 /* ------------------------------------------------- Agent Super Admin Controller ------------------------------------------------------------------------ */
 /* ------------------------------------------------------------------------------------------------------------------------------------------ */        
                    
            'agentSuperAdmin' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/agentSuperAdmin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AgentSuperAdmin\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(  
                    'index' => array(
                        'type' => 'segment',
                        'options'=> array(
                            'route' => '/index',
                            'constraints' => array(
                                    //'action1' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'index'
                            )
                        )
                    ),

                    'agentSuperAdminAuthenticate' => array(
                        'type' => 'segment',
                        'options'=> array(
                           'route' => '/agentSuperAdminAuthenticate',
                           'constraints' => array(
                                //'action1' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'agentSuperAdminAuthenticate'
                            )
                        )
                    ),

                    'agentSuperAdminDashboard' => array(
                        'type' => 'segment',
                        'options'=> array(
                           'route' => '/agentSuperAdminDashboard',
                           'constraints' => array(
                                //'action1' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'agentSuperAdminDashboard'
                            )
                        )
                    ),

                    'superAdminLogout' => array(
                        'type' => 'segment',
                        'options'=> array(
                           'route' => '/superAdminLogout',
                           'constraints' => array(
                                //'action1' => '[a-zA-Z0-9_-]+'
                            ),
                            'defaults' => array(
                                'action' => 'superAdminLogout'
                            )
                        )
                    ),
                    
                    

/*--------------------------------------- End of Agent Super Admin----------------------------------------------*/




/* ------------------------------------------------------------------------------------------------------------- */                   
 /* ------------------------------------------------- Agent small package Controller -------------------------- */
 /* ------------------------------------------------------------------------------------------------------------- */        
                   
                    'smallPackage' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/smallPackage',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AgentSuperAdmin\Controller',
                                'controller' => 'SmallPackage',
                                'action' => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(  
                            'index' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/index',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'index'
                                    )
                                )
                            ),
                            'add' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/add',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'add'
                                    )
                                )
                            ),

                            'ajaxList' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/ajaxList',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'ajaxList'
                                    )
                                )
                            ),

                            'status' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/status',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'status'
                                    )
                                )
                            ),

                            'edit' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/edit[/:id]',
                                    'constraints' => array(
                                        'id' => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'action' => 'edit'
                                    )
                                )
                            ),

                            'delete' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/delete[/:id]',
                                    'constraints' => array(
                                        'id' => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'action' => 'delete'
                                    )
                                )
                            ),





                        

                        ),
                    ),


                
/*--------------------------------------- End of Agent Super Admin Slider ----------------------------------------*/

/* ------------------------------------------------------------------------------------------------------------------------------------------ */                   
 /* --------------------------------Languages Controller ------------------------------------------------------------------------- */
 /* ------------------------------------------------------------------------------------------------------------------------------------------ */
            
                    'languages' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/languages',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AgentSuperAdmin\Controller',
                                'controller' => 'Languages',
                                'action' => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'default' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/[:controller[/:action]]',
                                    'constraints' => array(
                                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                    ),
                                ),
                            ),
                
                             /*Languages Add Action */
                            'add' => array(
                                'type' => 'segment',
                                'options' => array(
                                   'route' => '/add',
                                    'constraints' => array(
                                       
                                    ),
                                    'defaults' => array(
                                        'action' => 'add'
                                    )
                                )
                            ),
                           /* Languages end */

                            /*Languages ajaxlist Action */
                            'ajaxList' => array(
                                'type' => 'segment',
                                'options' => array(
                                   'route' => '/ajaxList',
                                    'constraints' => array(
                                        'id' => '[0-9]+',                                       
                                    ),
                                    'defaults' => array(
                                        'action' => 'ajaxList'
                                    )
                                )
                            ),
                            /* Languages ajaxlist Action End */

                            /*Languages ajaxAdminlist Action */
                            'ajaxAdminList' => array(
                                'type' => 'segment',
                                'options' => array(
                                   'route' => '/ajaxAdminList',
                                    'constraints' => array(
                                        'id' => '[0-9]+',                                       
                                    ),
                                    'defaults' => array(
                                        'action' => 'ajaxAdminList'
                                    )
                                )
                            ),
                            /* Languages ajaxAdminlist Action End */

                            /*Languages status Action */
                            'status' => array(
                                'type' => 'segment',
                                'options' => array(
                                   'route' => '/status[/:id]',
                                    'constraints' => array(
                                        'id' => '[0-9]+',                                       
                                    ),
                                    'defaults' => array(
                                        'action' => 'status'
                                    )
                                )
                            ),
                            /* Languages status Action End */

                            
                             /*Languages edit Action*/
                            'edit' => array(
                                'type' => 'segment',
                                'options' => array(
                                   'route' => '/edit[/:id]',
                                    'constraints' => array(
                                        'id' => '[0-9]+',                                       
                                    ),
                                    'defaults' => array(
                                        'action' => 'edit'
                                    )
                                )
                            ),
                            /* Languages status Action End */


                        )
                    ),
/*------------------------------------------------------------------------------------------------*/
/*----------------------------------languages  Controller End -----------------------------------------*/            
/*------------------------------------------------------------------------------------------------*/


/* ------------------------------------------------------------------------------------------------------------- */                   
 /* ------------------------------------------------- Agent Super Big Package Controller -------------------------- */
 /* ------------------------------------------------------------------------------------------------------------- */        
                   
                    'bigPackage' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/bigPackage',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AgentSuperAdmin\Controller',
                                'controller' => 'BigPackage',
                                'action' => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(  
                            'index' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/index',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'index'
                                    )
                                )
                            ),
                            'add' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/add',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'add'
                                    )
                                )
                            ),

                            'ajaxList' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/ajaxList',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'ajaxList'
                                    )
                                )
                            ),
                        ),
                    ),
/*--------------------------------------- End of Agent Super Admin Big Package ----------------------------------------*/

/* ------------------------------------------------------------------------------------------------------------- */                   
 /* ------------------------------------------------- Common Settings Controller -------------------------- */
 /* ------------------------------------------------------------------------------------------------------------- */        
                   
                    'commonSettings' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/commonSettings',
                            'defaults' => array(
                                '__NAMESPACE__' => 'AgentSuperAdmin\Controller',
                                'controller' => 'CommonSettings',
                                'action' => 'index'
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(  
                            'index' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/index',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'index'
                                    )
                                )
                            ),


                            'ajaxList' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/ajaxList',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'ajaxList'
                                    )
                                )
                            ),

                            'status' => array(
                                'type' => 'segment',
                                'options'=> array(
                                    'route' => '/status',
                                    'constraints' => array(
                                        //'action1' => '[a-zA-Z0-9_-]+'
                                    ),
                                    'defaults' => array(
                                        'action' => 'status'
                                    )
                                )
                            ),
                            
                            
                        ),
                    ),
/*--------------------------------------- End of Common Settings ----------------------------------------*/






                ),
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
            'AgentSuperAdmin\Controller\Index' => 'AgentSuperAdmin\Controller\IndexController',
            'AgentSuperAdmin\Controller\SmallPackage' => 'AgentSuperAdmin\Controller\SmallPackageController',
            'AgentSuperAdmin\Controller\BigPackage' => 'AgentSuperAdmin\Controller\BigPackageController',
            'AgentSuperAdmin\Controller\CommonSettings' => 'AgentSuperAdmin\Controller\CommonSettingsController',
            'AgentSuperAdmin\Controller\Languages' =>'AgentSuperAdmin\Controller\LanguagesController',
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'agentSuperAdmin/layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'agentSuperAdmin/index/index' => __DIR__ . '/../view/agentSuperAdmin/index/index.phtml',
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