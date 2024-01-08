<?php

namespace App\EventSubscriber;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseSubscriber implements EventSubscriberInterface
{
    #[ArrayShape([ResponseEvent::class => "string"])]
    public static function getSubscribedEvents() : array
    {
        return [ResponseEvent::class => 'onResponse'];
    }

    public function onResponse(ResponseEvent $event): void
    {
        if ($event->isMainRequest()) {
            $response = $event->getResponse();
            $response->headers->set('x-task', '1');
        }
    }
}