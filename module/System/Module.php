<?php

namespace System;

class Module
{

    protected $em = null;

    public function onBootstrap($e)
    {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $events->attach('ZfcUser\Form\Register', 'init', array($this, 'extendRegistration'));
        $events->attach('ZfcUser\Form\RegisterFilter', 'init', array($this, 'FilterRegistration'));
        $entityManager = $e->getApplication()->getServiceManager()->get('doctrine.entity_manager.orm_default');
        $this->em = $entityManager;
        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        // Store the field
        $zfcServiceEvents->attach('register', function($e) use($entityManager)
                {
                    $form = $e->getParam('form');
                    $user = $e->getParam('user');

                    /* @var $user \FooUser\Entity\User */
                    $user->setFirstName($form->get('first_name')->getValue());
                    $guest = $entityManager->getRepository('System\Entity\Role')->findOneBy(array('roleId' => 'guest'));
                    $role = new \System\Entity\Role();
                    $role->setParent($guest);
                    $role->setRoleId('user');
                    $user->addRole($role);
                });
    }

    public function extendRegistration($e)
    {
        $objectManager = $this->em;
        $form = $e->getTarget();
        $form->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'user',
            'options' => array(
                'label' => 'Dynamic ObjectManager Select',
                'object_manager' => $objectManager,
                'target_class' => 'System\Entity\User',
                'property' => 'email',
                'empty_option' => '--- please choose ---',
                'find_method' => array(
                    'name' => 'fetchUsers',
                    'params' => array('status' => 1),
                ),
            ),
        ));
    }

    public function FilterRegistration($e)
    {
        $filter = $e->getTarget();
        $filter->add(array(
            'name' => 'first_name',
            'required' => true,
            'allowEmpty' => false,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                )
            ),
        ));
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}
