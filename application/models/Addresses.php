<?php

namespace Application\Models;

use Core\Application;
use Core\Db\MysqlAdapter;
use Application\Models\DbTable\Addresses as DbAddresses;

class Addresses
{
    public function getAddress($id)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->getAddress($id);
    }

    public function getAllAddresses()
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->getAllAddresses();
    }

    public function add(array $data)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->add($data);
    }
}
