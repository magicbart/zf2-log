<?php
namespace Log\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    /**
     * @return array|void
     */
    public function indexAction()
    {
        $list = $this->getServiceLocator()->get('Log\Model\LogTable')->fetchLast();
        foreach ($list as $log) {
            echo $log->timestamp . '#' . $log->priorityName . '#' . nl2br($log->message) . '<hr />';
        }
        exit;
    }
}
