<?php

namespace Log\Service\Factory;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as StreamWriter;
use Zend\Log\Writer\Db as DbWriter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory class for Logger.
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbconfig = array(
            'driver' => 'Pdo',
            'dsn' => 'sqlite:' . 'data/sqlite/log.db',
        );

        $db = new DbAdapter($dbconfig);

        $writer1 = new StreamWriter('./data/log/' . date('Y-m-d') . '-error.log');
        $writer2 = new DbWriter($db, 'log');
        $writer2->addFilter(new Priority(Logger::CRIT));

        $logger = new Logger();

        $logger->addWriter($writer1);
        $logger->addWriter($writer2);

        return $logger;
    }
}
