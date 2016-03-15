<?php

namespace AppBundle\Listener;

use Doctrine\ORM\Mapping\PreFlush;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserListener
{
    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @PreFlush
     * @param User $user
     */
    public function preFlushHandler(User $user)
    {
        $plainPassword = $user->getPlainPassword();
        if (!empty($plainPassword)) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($plainPassword, $user->getSalt()));
            $user->eraseCredentials();
        }
    }
}