<?php

namespace Log;

use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

/**
 * Defines the log module.
 */
class Module implements
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ControllerProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var MvcEvent $e */
        //----- events
        $eventManager = $e->getApplication()->getEventManager();

        //----- Log an exception
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach(
            'Zend\Mvc\Application',
            'dispatch.error',
            function ($e) use ($sm) {
                /** @var MvcEvent $e */
                if ($e->getParam('exception')) {
                    $sm->get('logger')->crit($e->getParam('exception'));

                    $request = $e->getRequest();
                    if ($request instanceof Request) {
                        if ($request->isXmlHttpRequest()) {
                            $jsonModel = new JsonModel(
                                array(
                                    'success' => false,
                                    'message' => 'EXCEPTION'
                                )
                            );
                            $e->setViewModel($jsonModel);
                            $e->stopPropagation();
                            return $jsonModel;
                        }
                    }
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerConfig()
    {
        return array(
            'invokables' => array(
                'log\index' => 'Log\Controller\IndexController',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'logger' => 'Log\Service\Factory\LoggerFactory',
            ),
            'invokables' => array(
                'Log\Model\LogTable' => 'Log\Model\LogTable'
            ),
        );
    }
}
