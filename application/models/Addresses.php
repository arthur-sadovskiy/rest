<?php

namespace Application\Models;

use Core\Application;
use Core\Db\MysqlAdapter;
use Application\Models\DbTable\Addresses as DbAddresses;

/**
 * Class Addresses
 * @package Application\Models
 */
class Addresses
{
    /**
     * Stores primary key fieldname
     * @var string
     */
    private $_primaryKey = 'addressid';

    /**
     * Stores list of all fields (except primary key) and appropriate rules for theirs validation
     * @var array
     */
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

    /**
     * Retrieves data about all records or some specific record, in case
     * id of the record was provided
     *
     * @param null|int $id
     * @return array
     */
    public function get($id = null)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return empty($id)
            ? $addressesTable->getAllAddresses()
            : $addressesTable->getAddress($id);
    }

    /**
     * Performs adding of new item
     *
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->add($data);
    }

    /**
     * Updates record by provided id
     *
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->update($id, $data);
    }

    /**
     * Removes record by provided id
     *
     * @param int $id
     * @return int
     */
    public function delete($id)
    {
        $config = Application::getConfig();
        $pdoAdapter = new MysqlAdapter($config['database']);
        $addressesTable = new DbAddresses($pdoAdapter);

        return $addressesTable->delete($id);
    }

    /**
     * Performs validation of provided data
     *
     * @param array $data
     * @param bool $isForCreate
     * @return bool
     */
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

    /**
     * Gets list of fields
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }
}
