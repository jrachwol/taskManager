<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="data_user")
 * @ORM\Entity()
 */
class DataUser {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
    

    /**
     * @ORM\Column(type="string", length = 25, nullable = true)
     *
     */
	private $name;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="User"
     * )
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     nullable = true
     * )
     *
     */
    private $idUser;


    /**
     * @ORM\Column(type="string", length = 120, nullable = true)
     *
     */
	private $lastName;


    /**
     * @ORM\Column(type="string", nullable = true)
     * @Assert\Url()
     */
	private $www;


    /**
     * @ORM\Column(type="string", length = 420, nullable = true)
     *
     */
	private $about;

    /**
     * @ORM\Column(type="integer", nullable = true)
     * @Assert\Length(
     *     min = 9,
     *     max = 9
     * )
     *
     */
    private $phone;


//////////////////////////////////////////////


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return DataUser
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return DataUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set www
     *
     * @param string $www
     *
     * @return DataUser
     */
    public function setWww($www)
    {
        $this->www = $www;

        return $this;
    }

    /**
     * Get www
     *
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return DataUser
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return DataUser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\User $idUser
     *
     * @return DataUser
     */
    public function setIdUser(\AppBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
