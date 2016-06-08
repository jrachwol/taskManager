<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubscribeRepository")
 * @ORM\Table(name="subscribe")
 */
class Subscribe {


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "user_id",
     *      referencedColumnName = "id",
     *      nullable = false
     * )
     */
    private $idUser;


    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Task"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "task_id",
     *      referencedColumnName = "id",
     *      nullable = false,
     *
     * )
     */
    private $idTask;


    /**
     * @ORM\Column(type="datetime")
     */
    private $subscribeDate;



/////////////////////////////////////////////////


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subscribeDate = new \DateTime();
    }


/////////////////////////////////////////////////


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
     * Set subscribeDate
     *
     * @param \DateTime $subscribeDate
     *
     * @return Subscribe
     */
    public function setSubscribeDate($subscribeDate)
    {
        $this->subscribeDate = $subscribeDate;

        return $this;
    }

    /**
     * Get subscribeDate
     *
     * @return \DateTime
     */
    public function getSubscribeDate()
    {
        return $this->subscribeDate;
    }
    

    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\User $idUser
     *
     * @return Subscribe
     */
    public function setIdUser(\AppBundle\Entity\User $idUser)
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

    /**
     * Set idTask
     *
     * @param \AppBundle\Entity\Task $idTask
     *
     * @return Subscribe
     */
    public function setIdTask(\AppBundle\Entity\Task $idTask)
    {
        $this->idTask = $idTask;

        return $this;
    }

    /**
     * Get idTask
     *
     * @return \AppBundle\Entity\Task
     */
    public function getIdTask()
    {
        return $this->idTask;
    }
}
