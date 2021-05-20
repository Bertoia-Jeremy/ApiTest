<?php
namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{

    public function updateJwtData(JwtCreatedEvent $event)
    {
        $user = $event->getUser();

        $data = $event->getData();
        $data['firstname'] = $user->getFirstName();
        $data['lastname'] = $user->getLastName();

        $event->setData($data);
    }
}