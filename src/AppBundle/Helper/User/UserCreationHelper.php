<?php

namespace AppBundle\Helper\User;
use AppBundle\Entity\User;

class UserCreationHelper
{
    private $user;
    private $encoder;

    public function __construct(User $user, $encoder)
    {
        $this->user = $user;
        $this->encoder = $encoder;
    }

    public function execute()
    {
        $this->addRegistrationDate();
        $this->encodePassword();
        return $this;
    }

    private function addRegistrationDate()
    {
        if($this->user->setRegistrationDate(new \DateTime())) return true;
        throw new \Exception('Impossibile stabilire la data di registrazione dell\'utente');
    }

    private function encodePassword()
    {
        $plainPassword = $this->user->getPassword();
        $encoded = $this->encoder->encodePassword($this->user, $plainPassword);
        $this->user->setPassword($encoded);
    }

}