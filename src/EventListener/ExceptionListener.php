<?php


namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $exceptionEvent)
    {
         $exception = $exceptionEvent->getThrowable();
         if($exception instanceof UsernameNotFoundException){

         }
    }
}