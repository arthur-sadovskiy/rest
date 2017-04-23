<?php

namespace Core\Db;

class MysqlAdapter
{
    private $_config;

    private $_connection;

    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    public function connect()
    {
        if ($this->_connection === null) {
            $dsn = "mysql:host={$this->_config['host']};dbname={$this->_config['database']}";
            $this->_connection = new \PDO($dsn, $this->_config['user'], $this->_config['pass']);
        }

        return $this->_connection;
    }

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
}
