<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @UniqueEntity(
 * fields={"email"},
 * message="l'email est deja utilise!"
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uesrname;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\EqualTo(propertyPath="confirm_password" , message="il faut taper le meme motdepasse ")
     *  @Assert\Length(min="8",minMessage="au moins 8 carractere")
     */
    private $password;

    /**
     *  @Assert\EqualTo(propertyPath="password" , message="il faut taper le meme motdepasse ")
     * @ORM\Column(type="string", length=255)
     */
    private $confirm_password;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUesrname(): ?string
    {
        return $this->uesrname;
    }

    public function setUesrname(string $uesrname): self
    {
        $this->uesrname = $uesrname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }
}
