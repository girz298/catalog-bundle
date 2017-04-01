<?php

namespace CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForgotPassword
 *
 * @ORM\Table(name="forgot_password")
 * @ORM\Entity(repositoryClass="CatalogBundle\Repository\ForgotPasswordRepository")
 */
class ForgotPassword
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="hashedKey", type="string", length=255)
     */
    private $hashedKey;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return ForgotPassword
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set hashedKey
     *
     * @param string $hashedKey
     *
     * @return ForgotPassword
     */
    public function setHashedKey($hashedKey)
    {
        $this->hashedKey = $hashedKey;

        return $this;
    }

    /**
     * Get hashedKey
     *
     * @return string
     */
    public function getHashedKey()
    {
        return $this->hashedKey;
    }
}

