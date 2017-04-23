<?php

namespace Application\Models\DbTable;

use Core\Db\MysqlAdapter;

class Addresses
{
    private $_adapter;

    public function __construct(MysqlAdapter $dbAdapter)
    {
        $this->_adapter = $dbAdapter;
    }

    public function getAddress($id)
    {
        $sql = "SELECT * FROM address WHERE addressid = ?";
        $param = [$id];

        return $this->_adapter->fetchRow($sql, $param);
    }

    public function getAllAddresses()
    {
        $sql = "SELECT * FROM address";

        return $this->_adapter->fetchAll($sql);
    }
}
