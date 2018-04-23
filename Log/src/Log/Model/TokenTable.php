<?php
namespace Log\Model;

use Zend\Db\Adapter\Adapter as dbAdapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TokenTable extends TableGateway
{
    protected $table = 'token';

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
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Token());
        $this->initialize();
    }

    /**
     *
     */
    public function resetKey()
    {
        $this->delete(array());
        $this->insert(array('key' => sha1(rand().microtime())));
    }

    /**
     *
     */
    public function getKey()
    {
        $results = $this->select();
        return $results->current()->key;
    }
}
