<?php

namespace System\Service;

class Service
{

    private $_em = null;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    public function getUserList()
    {
        return $this->_em->getRepository('System\Entity\User')->findAll();
    }

}

?>
