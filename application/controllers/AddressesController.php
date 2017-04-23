<?php

namespace Application\Controllers;

use Application\Models\Addresses;
use Core\Controller;
use Core\JsonView;

class AddressesController extends Controller
{
    public function getAction()
    {
        $model = new Addresses();
        if ($this->_request->isIdSet()) {
            // retrieve single record
            $addressId = (int) $this->_request->getId();
            $data = ['message' => $model->getAddress($addressId)];
        } else {
            // retrieve all records
            $data = ['message' => $model->getAllAddresses()];
        }

        return new JsonView($data);
    }

    public function postAction()
    {
        // TODO
    }
}
