<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use App\Entity\User;

use function PHPUnit\Framework\throwException;

class CheckVerifiedUser implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => 'onCheckPassport',
        ];
    }

    public function onCheckPassport(CheckPassportEvent $event)
    {

        $passport = $event->getPassport();
        $user = $passport->getUser();
        if ($user instanceof User) {
            if (!$user->isVerified()) {
                throw new \Exception("Merci de vérifier votre mail avant de continuer");
            }
            // dd($user);
        }
    }
}
