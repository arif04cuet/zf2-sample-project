<?php

namespace System\Service;

use System\Service\Service as serviceManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $services)
    {
        $em = $services->get('doctrine.entity_manager.orm_default');
        $service = new serviceManager($em);
        return $service;
    }

}
