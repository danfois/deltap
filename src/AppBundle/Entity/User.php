<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity("username", message="Username already taken.")
 */

class User implements UserInterface
{
    /**
     * @ORM\Column(type="string", length=16, unique=true, nullable=false)
     * @Assert\NotBlank(message="You must provide an username")
     * @Assert\Length(
     *     min = 4,
     *     max = 16,
     *     minMessage = "Username has to be long at least 4 chars",
     *     maxMessage = "Username cannot exceed 16 chars"
     * )
     * @Assert\Regex("/^[\w.-]*$/", message = "Username can contain only letters, digits, - and _")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=4096, nullable=false)
     * @Assert\NotBlank(message="You must provide a valid password")
     * @Assert\Length(
     *     min = 8,
     *     max = 16,
     *     minMessage = "Password has to be long at least 8 chars",
     *     maxMessage = "Password cannot exceed 16 chars"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="integer", name="id_user")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="You have to choose a Role")
     */
    private $roles = array();

    /**
     * @ORM\Column(type="integer", name="status", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", name="data_inserimento", nullable=true)
     */
    private $registration_date;


    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    public function __construct()
    {
        $this->roles = array();
    }


    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }


    public function __toString() {
        return (string)$this->id_user;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles()
    {   $roles = array();
        $roles = $this->roles;
        array_push($roles, $this->roles);

        return array_unique($roles);
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registration_date = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }
}
