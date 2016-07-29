<?php


namespace Mutabor\Application\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;


class RestController extends FOSRestController
{

    protected function errorView($data = null, $statusCode = null, array $groups = [])
    {
        $view = $this->view($data, $statusCode);
        $view->setSerializationContext(SerializationContext::create()->setGroups(array_merge(['Default', 'error'.$statusCode], $groups)));
        return $view;
    }

    protected function view($data = null, $statusCode = null, array $headers = array(), array $groups = [])
    {
        $view = parent::view($data, $statusCode, $headers);
        $view->setSerializationContext(SerializationContext::create()->setGroups(array_merge(['Default'], $groups)));
        return $view;
    }
}