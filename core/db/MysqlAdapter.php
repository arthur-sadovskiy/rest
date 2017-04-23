<?php

namespace Core\Db;

/**
 * Class MysqlAdapter
 * @package Core\Db
 */
class MysqlAdapter
{
    /**
     * Stores database config
     * @var array
     */
    private $_config;

    /**
     * Stores PDO instance
     * @var \PDO
     */
    private $_connection;

    /**
     * MysqlAdapter constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    /**
     * Performs new connection using PDO (if necessary) and returns its instance
     * @return \PDO
     */
    public function connect()
    {
        if ($this->_connection === null) {
            $dsn = "mysql:host={$this->_config['host']};dbname={$this->_config['database']}";
            $this->_connection = new \PDO($dsn, $this->_config['user'], $this->_config['pass']);
        }

        return $this->_connection;
    }

    /**
     * Fetches single row from the database
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchRow($sql, $params = [])
    {
        $this->connect();

        if (empty($params)) {
            $stmt = $this->_connection->query($sql);
        } else {
            $stmt = $this->_connection->prepare($sql);
            $stmt->execute($params);
        }

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = empty($result) ? [] : $result[0];

        return $result;
    }

    /**
     * Fetches all rows from the database
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll($sql, $params = [])
    {
        $this->connect();

        if (empty($params)) {
            $stmt = $this->_connection->query($sql);
        } else {
            $stmt = $this->_connection->prepare($sql);
            $stmt->execute($params);
        }

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Performs insert of the new record into database
     *
     * @param string $sql
     * @param array $data
     * @return int
     */
    public function insert($sql, array $data = [])
    {
        $this->connect();

        $dataKeys = array_keys($data);
        $dataValues = array_values($data);

        $columns = implode(', ', $dataKeys);
        $valuesCount = str_repeat('?, ', count($dataValues) - 1) . '?';

        $sql .= " ({$columns}) VALUES ({$valuesCount})";

        $stmt = $this->_connection->prepare($sql);
        $stmt->execute($dataValues);

        return $this->_connection->lastInsertId();
    }

    /**
     * Updates record in the database
     *
     * @param string $tableName
     * @param array $idFieldValue
     * @param array $data
     * @return int
     */
    public function update($tableName, array $idFieldValue, array $data)
    {
        $this->connect();

        $dataKeys = array_keys($data);
        $dataValues = array_values($data);

        foreach ($dataKeys as &$dataKey) {
            $dataKey = $dataKey . ' = ?';
        }
        $dataKeys = implode(', ', $dataKeys);

        $whereColumnField = array_keys($idFieldValue)[0];
        $whereColumnValue = array_values($idFieldValue)[0];
        $dataValues[] = $whereColumnValue;

        $sql = "UPDATE {$tableName} SET {$dataKeys} WHERE {$whereColumnField} = ?";

        $stmt = $this->_connection->prepare($sql);
        $stmt->execute($dataValues);

        return $stmt->rowCount();
    }

    /**
     * Removes record from the database
     *
     * @param string $tableName
     * @param array $idFieldValue
     * @return int
     */
    public function delete($tableName, array $idFieldValue)
    {
        $this->connect();

        $whereColumnField = array_keys($idFieldValue)[0];
        $whereColumnValue = array_values($idFieldValue);

        $sql = "DELETE FROM {$tableName} WHERE {$whereColumnField} = ?";
        $stmt = $this->_connection->prepare($sql);
        $stmt->execute($whereColumnValue);

        return $stmt->rowCount();
    }
}
