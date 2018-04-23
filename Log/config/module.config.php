<?php
return array(
    'router' => array(
        'routes' => array(
            'log-index' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/log[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'log\index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
);
