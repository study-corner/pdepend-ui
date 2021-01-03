<?php
declare(strict_types=1);

namespace App\Subscriber;

use App\Serialization\User;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

class UserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            [
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerialize',
                'class' => User::class
            ],
            [
                'event' => 'serializer.pre_deserialize',
                'method' => 'onPreDeserialize',
                'class' => User::class
            ],
            [
                'event' => 'serializer.post_deserialize',
                'method' => 'onPostDeserialize',
                'class' => User::class
            ]
        ];
    }

    public function onPreSerialize(PreSerializeEvent $event)
    {
        $user = $event->getObject();
    }

    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        $data = $event->getData();
    }

    public function onPostDeserialize(ObjectEvent $event)
    {
        $user = $event->getObject();
    }
}