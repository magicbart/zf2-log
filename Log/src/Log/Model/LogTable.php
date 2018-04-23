<?php
namespace Log\Model;

use Zend\Db\Adapter\Adapter as dbAdapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class LogTable extends TableGateway
{
    protected $table = 'log';

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $adapter = new DbAdapter(array(
            'driver' => 'Pdo_Sqlite',
            'database' => 'data/sqlite/log.db'
        ));

        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Log());
        $this->initialize();
    }


    /**
     * @return ResultSet
     */
    public function fetchLast()
    {
        $resultSet = $this->select( function (Select $select) {
            $select->order('timestamp DESC');
            $select->limit(4);
        });
        return $resultSet;
    }

    /**
     * Search in log
     * @param int $page
     * @return Paginator
     */
    public function search($page = 1)
    {
        $select = new Select();
        $select->from(array('a' => 'log'))
            ->columns(array('*'));
        $select->order('timestamp DESC');

        $adapter = new DbSelect($select, $this->getAdapter(), $this->resultSetPrototype);
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(3);
        return $paginator;
    }
}
