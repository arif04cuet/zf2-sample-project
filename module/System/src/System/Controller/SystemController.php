<?php

namespace System\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SystemController extends AbstractActionController
{

    private $_service = null;

    public function setService(\System\Service\Service $service)
    {
        $this->_service = $service;
    }

    public function indexAction()
    {
        return new ViewModel(array('list'=>  $this->_service->getUserList()));
    }

}