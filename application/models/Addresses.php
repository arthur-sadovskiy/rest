<?php

namespace Application\Models;

use Core\Application;
use Core\Db\MysqlAdapter;
use Application\Models\DbTable\Addresses as DbAddresses;

class Addresses
{
    public function get($id = null)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return empty($id)
            ? $addressesTable->getAllAddresses()
            : $addressesTable->getAddress($id);
    }

    public function add(array $data)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->add($data);
    }
}
