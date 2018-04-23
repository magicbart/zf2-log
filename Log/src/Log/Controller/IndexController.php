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
        $key1 = $this->params()->fromQuery('key', null);

        $key2 = $this->getServiceLocator()->get('Log\Model\TokenTable')->getKey();

        if ($key1 == $key2) {
            $list = $this->getServiceLocator()
                ->get('Log\Model\LogTable')
                ->fetchLast();
            foreach ($list as $log) {
                echo $log->timestamp . '#' . $log->priorityName . '#' . nl2br($log->message) . '<hr />';
            }
        }
        exit;
    }

    /**
     *
     */
    public function resetTokenAction()
    {
        $this->getServiceLocator()->get('Log\Model\TokenTable')->resetKey();
        echo "NEW KEY GENERATED";
        exit;
    }
}
