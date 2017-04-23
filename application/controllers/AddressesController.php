<?php

namespace Application\Controllers;

use Application\Models\Addresses;
use Core\Controller;
use Core\JsonView;

/**
 * Class AddressesController
 * @package Application\Controllers
 */
class AddressesController extends Controller
{
    /**
     * Handles 'GET' requests for retrieving data
     * @return JsonView
     */
    public function getAction()
    {
        $model = new Addresses();
        $isValidRequest = true;
        if ($this->_request->isIdSet()) {
            // retrieve single record
            $addressId = $this->_request->getId();
            if (!is_int($addressId)) {
                $isValidRequest = false;
                $result = ['error' => 'AddressId must be an integer'];
            } else {
                $result = $model->get($addressId);
            }

        } else {
            // retrieve all records
            $result = $model->get();
        }

        $view = new JsonView($result);
        if (!$isValidRequest) {
            $view->setIsBadRequest(true);
        } elseif (empty($result) && isset($addressId)) {
            $view->setIsNotFound(true);
        }

        return $view;
    }

    /**
     * Handles 'POST' requests for posting data
     * (used to create new items)
     *
     * @return JsonView
     */
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

    /**
     * Handles 'PATCH' requests for updating data of some item
     * @return JsonView
     */
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
            $addressId = $this->_request->getId();
            if (!is_int($addressId)) {
                $isValidRequest = false;
                $result = ['error' => 'AddressId must be an integer'];
            } else {
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
        }

        $view = new JsonView($result);
        if (!$isValidRequest || !$isValidInput) {
            $view->setIsBadRequest(true);
        }
        return $view;
    }

    /**
     * Handles 'DELETE' requests for removing certain item
     * @return JsonView
     */
    public function deleteAction()
    {
        $isValidRequest = true;
        if (!$this->_request->isIdSet()) {
            $isValidRequest = false;
            $result = ['error' => 'AddressId must be provided for record delete in url'];
        } else {
            $addressId = $this->_request->getId();
            if (!is_int($addressId)) {
                $isValidRequest = false;
                $result = ['error' => 'AddressId must be an integer'];
            } else {
                $isDeleted = (new Addresses())->delete($addressId);
                $result = [];
                if (!$isDeleted) {
                    $isValidRequest = false;
                    $result = ['error' => 'Wrong AddressId was provided for record delete in url'];
                }
            }
        }

        $view = new JsonView($result);
        if (!$isValidRequest) {
            $view->setIsBadRequest(true);
        }
        return $view;
    }
}
