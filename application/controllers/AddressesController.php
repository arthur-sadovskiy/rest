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
            $result = $model->get($addressId);

        } else {
            // retrieve all records
            $result = $model->get();
        }

        $view = new JsonView($result);
        if (empty($result) && isset($addressId)) {
            $view->setIsNotFound(true);
        }

        return $view;
    }

    public function postAction()
    {
        $bodyParams = $this->_request->getBodyParams();

        if (!$this->_request->getIsJson()) {
            $isValidInput = false;
            $result = ['error' => 'Input data must be in JSON format'];
        } elseif ($this->_request->isIdSet()) {
            $isValidInput = false;
            $result = ['error' => 'Method PATCH must be used for record update'];

        } elseif (!empty($bodyParams)) {
            $model = new Addresses();
            $isValidInput = $model->validate($bodyParams, $isForCreate = true);
            if ($isValidInput) {
                $result = [];
                $addressId = $model->add($bodyParams);

            } else {
                $fields = $model->getFields();
                $requiredFields = [];
                foreach ($fields as $fieldName => $fieldRules) {
                    $maxLength = $fieldRules['maxlength'];
                    $requiredFields[] = "$fieldName (maxlength: $maxLength)";
                }
                $requiredFields = implode(', ', $requiredFields);
                $result = ['error' => 'New address must contain only these fields: ' . $requiredFields];
            }

        } else {
            $result = ['error' => 'Attempt to create new address with empty body'];
        }

        $view = new JsonView($result);
        if (empty($bodyParams) || !$isValidInput) {
            $view->setIsBadRequest(true);

        } elseif (isset($addressId)) {
            $view->setIsCreated(true);

            $newLocation = "/{$this->_request->getController()}/$addressId";
            $view->setLocation($newLocation);
        }
        return $view;
    }

    public function patchAction()
    {
        $isValidRequest = true;
        $bodyParams = $this->_request->getBodyParams();

        if (!$this->_request->getIsJson()) {
            $isValidRequest = false;
            $result = ['error' => 'Input data must be in JSON format'];
        } elseif (!$this->_request->isIdSet()) {
            $isValidRequest = false;
            $result = ['error' => 'AddressId must be provided for record update in url'];
        } elseif (empty($bodyParams)) {
            $isValidRequest = false;
            $result = ['error' => 'Attempt to update address with empty body'];
        } else {
            $addressId = (int) $this->_request->getId();
            $model = new Addresses();
            $isValidInput = $model->validate($bodyParams, $isForCreate = false);
            if ($isValidInput) {
                $result = [];
                $isUpdated = $model->update($addressId, $bodyParams);
                if (!$isUpdated) {
                    $isValidInput = false;
                    $result = ['error' => 'Wrong AddressId was provided for record update in url'];
                }

            } else {
                $fields = $model->getFields();
                $requiredFields = [];
                foreach ($fields as $fieldName => $fieldRules) {
                    $maxLength = $fieldRules['maxlength'];
                    $requiredFields[] = "$fieldName (maxlength: $maxLength)";
                }
                $requiredFields = implode(', ', $requiredFields);
                $result = ['error' => 'List of possible fields of address available for update: ' . $requiredFields];
            }
        }

        $view = new JsonView($result);
        if (!$isValidRequest || !$isValidInput) {
            $view->setIsBadRequest(true);
        }
        return $view;
    }

    public function deleteAction()
    {
        $isValidRequest = true;
        if (!$this->_request->isIdSet()) {
            $isValidRequest = false;
            $result = ['error' => 'AddressId must be provided for record delete in url'];
        } else {
            $addressId = (int) $this->_request->getId();
            $isDeleted = (new Addresses())->delete($addressId);
            $result = [];
            if (!$isDeleted) {
                $isValidRequest = false;
                $result = ['error' => 'Wrong AddressId was provided for record delete in url'];
            }
        }

        $view = new JsonView($result);
        if (!$isValidRequest) {
            $view->setIsBadRequest(true);
        }
        return $view;
    }
}
