<?php

namespace Application\Models;

use Core\Application;
use Core\Db\MysqlAdapter;
use Application\Models\DbTable\Addresses as DbAddresses;

class Addresses
{
    private $_primaryKey = 'addressid';

    private $_fields = [
        'label' => [
            'maxlength' => 100
        ],
        'street' => [
            'maxlength' => 100
        ],
        'housenumber' => [
            'maxlength' => 10
        ],
        'postalcode' => [
            'maxlength' => 6
        ],
        'city' => [
            'maxlength' => 100
        ],
        'country' => [
            'maxlength' => 100
        ]
    ];

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

    public function update($id, array $data)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->update($id, $data);
    }

    public function delete($id)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->delete($id);
    }
    
    public function validate(array $data, $isForCreate = false)
    {
        $isValid = true;

        if (isset($data[$this->_primaryKey])) {
            $isValid = false;

        } else {
            $requiredFields = $this->_fields;

            foreach ($requiredFields as $fieldName => $fieldRules) {
                // make sure that all required fields are present
                if ($isForCreate && !isset($data[$fieldName])) {
                    $isValid = false;
                    break;
                }

                // make sure that field length is OK
                if (!$isForCreate && !isset($data[$fieldName])) {
                    // not all fields are required for update
                    // so we can skip it
                    continue;
                }

                $currentFieldLength = strlen($data[$fieldName]);
                $maxFieldLength = $fieldRules['maxlength'];
                if ($currentFieldLength > $maxFieldLength) {
                    $isValid = false;
                    break;
                }
            }
        }

        return $isValid;
    }

    public function getFields()
    {
        return $this->_fields;
    }
}
