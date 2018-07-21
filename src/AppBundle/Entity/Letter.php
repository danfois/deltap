<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="letters")
 */
class Letter
{
    /**
     * @ORM\Column(type="integer", name="letterId")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $letterId;

    /**
     * @ORM\Column(type="text", name="letter_body", nullable=true)
     */
    private $letterBody;

    /**
     * Get letterId
     *
     * @return integer
     */
    public function getLetterId()
    {
        return $this->letterId;
    }

    /**
     * Set letterBody
     *
     * @param string $letterBody
     *
     * @return Letter
     */
    public function setLetterBody($letterBody)
    {
        $this->letterBody = $letterBody;

        return $this;
    }

    /**
     * Get letterBody
     *
     * @return string
     */
    public function getLetterBody()
    {
        return $this->letterBody;
    }
}
