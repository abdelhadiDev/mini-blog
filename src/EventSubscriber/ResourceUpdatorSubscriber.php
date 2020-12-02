<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Entity\Article;
use App\Services\ResourceUpdatorInterface;

class ResourceUpdatorSubscriber implements EventSubscriberInterface  
{
    private ResourceUpdatorInterface $resourceUpdator;

    public function __construct(ResourceUpdatorInterface $resourceUpdator)
    {
        $this->resourceUpdator = $resourceUpdator;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onPreValidate', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function onPreValidate(ViewEvent $event): void
    {
        $object = $event->getControllerResult();

        if ($object instanceof User || $object instanceof Article) {
            $user = $object instanceof User ? $object : $object->getAuthor();

            $canProcess = $this->resourceUpdator->process(
                $event->getRequest()->getMethod(), 
                $user
            );
            
            if ($canProcess) {
                $user->setUpdatedAt(new \DateTimeImmutable());
            }
        }

    }
} 