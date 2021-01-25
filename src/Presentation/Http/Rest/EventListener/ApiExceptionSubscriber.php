<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\EventListener;

use App\Presentation\Http\Rest\Exception\HttpExceptionMap;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiExceptionSubscriber.
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private HttpExceptionMap $httpExceptionMap;

    public function __construct(HttpExceptionMap $exceptionMap)
    {
        $this->httpExceptionMap = $exceptionMap;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $response = $this->httpExceptionMap->resolveExceptionResponse($event->getThrowable());
        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
