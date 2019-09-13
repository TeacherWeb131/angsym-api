<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncodingListener implements EventSubscriberInterface
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            "kernel.request" => ["convertUserPassword", 0]
        ];
    }

    public function convertUserPassword(RequestEvent $event)
    {
        $data = $event->getRequest()->attributes->get('data');
        $method = $event->getRequest()->getMethod();
        //  Si je suis en trainde parler d'un User ET que je suis dans une request avec methode POST
        if (
            $data &&
            $data instanceof User &&
            $method === "POST" &&
            $data->getPassword() !== ""
        ) {
            $plainPassword = $data->getPassword();
            $hash = $this->encoder->encodePassword($data, $plainPassword);

            $data->setPassword($hash);
        }
    }
}
