<?php
namespace Log\Model;

use Zend\Db\Adapter\Adapter as dbAdapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

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
}
