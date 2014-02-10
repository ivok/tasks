<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'tickets' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/tickets[/][:action][/:page]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'page'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Application\Controller\Task',
                         'action'     => 'index',
                     ),
                 ),
                'may_terminate' => true,
                'child_routes' => array(
                    'mytasks' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Task',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            //Index Controller
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'users' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/users',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'users',
                    ),
                ),
            ),
            //Task Controller
            'tasks' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/tasks',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Task',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'mytasks' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/mytasks',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Task',
                                'action' => 'mytasks',
                            )
                        ),
                    ),
                    'pending' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/pending',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Task',
                                'action' => 'pending'
                            )
                        ),
                    ),
                    'resolved' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/resolved',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Task',
                                'action' => 'resolved'
                            )
                        ),
                    ),
                ),
            ),

            //index controller
//            'login' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/login',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Auth',
//                        'action' => 'login',
//                    ),
//                ),
//            ),
//            'logout' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/logout',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Auth',
//                        'action' => 'logout',
//                    ),
//                ),
//            ),
//            'register' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/register',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Auth',
//                        'action' => 'register',
//                    ),
//                ),
//            ),
//            'settings' => array(
//                'type' => 'Zend\Mvc\Router\Http\Literal',
//                'options' => array(
//                    'route' => '/settings',
//                    'defaults' => array(
//                        'controller' => 'Application\Controller\Auth',
//                        'action' => 'settings',
//                    ),
//                ),
//            ),
            // Project Controller
            'projects' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/projects',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Project',
                        'action' => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
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
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Task' => 'Application\Controller\TaskController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Project' => 'Application\Controller\ProjectController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(),
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities',
                )
            )
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Tickets',
                'route' => 'tickets',
                'pages' => array(
                    array(
                        'label' => 'My tickets',
                        'route' => 'mytasks'
                    ),
                ),
            ),
            array(
                'label' => 'Projects',
                'route' => 'projects',
                'pages' => array(
                    array(
                        'label' => 'All projects',
                        'route' => 'projects'
                    ),
                ),
            ),
            array(
                'label' => 'Users',
                'route' => 'users',
                'pages' => array(
                    array(
                        'label' => 'All users',
                        'route' => 'users'
                    ),
                ),
            ),

        ),
    ),
);
