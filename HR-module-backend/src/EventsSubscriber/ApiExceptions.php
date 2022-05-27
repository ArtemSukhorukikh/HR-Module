<?php

namespace App\EventsSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptions implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $data = [
            'status_code' => $statusCode,
            'message' => $e->getMessage(),
        ];

        $event->setResponse(new JsonResponse($data, $statusCode));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}