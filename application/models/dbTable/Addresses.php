<?php

namespace Application\Models\DbTable;

use Core\Db\MysqlAdapter;

/**
 * Class Addresses
 * @package Application\Models\DbTable
 */
class Addresses
{
    /**
     * Stores instance of db adapter
     * @var MysqlAdapter
     */
    private $_adapter;

    /**
     * Stores tablename
     * @var string
     */
    private $_tableName = 'address';
    /**
     * Stores primary key field name
     * @var string
     */
    private $_keyField = 'addressid';

    /**
     * Addresses constructor.
     * @param MysqlAdapter $dbAdapter
     */
    public function __construct(MysqlAdapter $dbAdapter)
    {
        $this->_adapter = $dbAdapter;
    }

    /**
     * Retrieves whole info for certain record
     *
     * @param int $id
     * @return array
     */
    public function getAddress($id)
    {
        $sql = "SELECT * FROM {$this->_tableName} WHERE {$this->_keyField} = ?";
        $param = [$id];

        return $this->_adapter->fetchRow($sql, $param);
    }

    /**
     * Retrieves whole info for all records
     * @return array
     */
    public function getAllAddresses()
    {
        $sql = "SELECT * FROM {$this->_tableName}";

        return $this->_adapter->fetchAll($sql);
    }

    /**
     * Adds new record
     *
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        $sql = "INSERT INTO {$this->_tableName}";

        return $this->_adapter->insert($sql, $data);
    }

    /**
     * Updates record by id
     *
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data)
    {
        return $this->_adapter->update(
            $this->_tableName,
            [$this->_keyField => $id],
            $data
        );
    }

    /**
     * Removes record by id
     *
     * @param int $id
     * @return int
     */
    public function delete($id)
    {
        return $this->_adapter->delete(
            $this->_tableName,
            [$this->_keyField => $id]
        );
    }
}
