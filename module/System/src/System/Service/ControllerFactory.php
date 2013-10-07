<?php

namespace System\Service;

use System\Controller\SystemController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $controller)
    {
        $sm = $controller->getServiceLocator();
        $service = $sm->get('system-service');
        $controller = new SystemController();
        $controller->setService($service);
        return $controller;
    }

}
