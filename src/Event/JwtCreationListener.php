<?php

namespace App\Event;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreationListener
{
    public function injectDataIntoJwt(JWTCreatedEvent $event)
    {
        // 1. Récupérer l'utilisateur (propriété user qui se trouve dans $event)
        $user = $event->getUser();
        // 2. Récupérer son avatar
        $avatar = $user->getAvatar();
        // 3. Récupérer les données du tokent (propriété data dans $event)
        $data = $event->getData();
        // 4. Mettre l'avatar dans les données
        $data['avatar'] = $avatar;
        // 5. Remettre les nouvelles données dans $event
        $event->setData($data);
    }
}
