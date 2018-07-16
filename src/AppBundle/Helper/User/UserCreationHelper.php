<?php

namespace AppBundle\Helper\User;
use AppBundle\Entity\User;

class UserCreationHelper
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute()
    {
        $this->addRegistrationDate();
        return $this;
    }

    private function addRegistrationDate()
    {
        if($this->user->setRegistrationDate(new \DateTime())) return true;
        throw new \Exception('Impossibile stabilire la data di registrazione dell\'utente');
    }

}