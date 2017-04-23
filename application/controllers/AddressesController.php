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
            $data = ['message' => $model->get($addressId)];
        } else {
            // retrieve all records
            $data = ['message' => $model->get()];
        }

        return new JsonView($data);
    }

    public function postAction()
    {
        $bodyParams = $this->_request->getBodyParams();
        $data = ['message' => (new Addresses())->add($bodyParams)];

        return new JsonView($data);
    }

    public function patchAction()
    {
        if ($this->_request->isIdSet()) {
            $addressId = (int) $this->_request->getId();
            $bodyParams = $this->_request->getBodyParams();
            $data = ['message' => (new Addresses())->update($addressId, $bodyParams)];
        }

        return new JsonView($data);
    }

    public function deleteAction()
    {
        if ($this->_request->isIdSet()) {
            $addressId = (int) $this->_request->getId();
            $data = ['message' => (new Addresses())->delete($addressId)];
        }

        return new JsonView($data);
    }
}
