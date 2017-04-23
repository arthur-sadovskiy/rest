<?php

namespace Application\Models\DbTable;

use Core\Db\MysqlAdapter;

class Addresses
{
    private $_adapter;

    private $_tableName = 'address';
    private $_keyField = 'addressid';

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

    public function add(array $data)
    {
        $sql = "INSERT INTO address";

        return $this->_adapter->insert($sql, $data);
    }

    public function update($id, array $data)
    {
        return $this->_adapter->update(
            $this->_tableName,
            [$this->_keyField => $id],
            $data
        );
    }
}
