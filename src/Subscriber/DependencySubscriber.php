<?php
declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Dependencies;
use App\Serialization\User;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

class DependencySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerialize',
                'class' => Dependencies::class
            ],
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
                'class' => Dependencies::class
            ],
            [
                'event' => 'serializer.post_deserialize',
                'method' => 'onPostDeserialize',
                'class' => Dependencies::class
            ]
        ];
    }

    public function onPreSerialize(PreSerializeEvent $event)
    {
        $dependencies = $event->getObject();
    }

    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        /** @var \SimpleXMLElement $data */
        $data = $event->getData();
    }

    public function onPostDeserialize(ObjectEvent $event)
    {
        $dependencies = $event->getObject();
    }


}