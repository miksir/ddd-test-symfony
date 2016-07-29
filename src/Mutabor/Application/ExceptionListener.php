<?php


namespace Mutabor\Application;


use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    public function onKernelResponse(GetResponseForExceptionEvent $event)
    {
        return;
    }
}