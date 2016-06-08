<?php

namespace TmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 * @ORM\Table(name="success")
 */
class Success {

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
     * @ORM\Column(name="id_subscribe", type="integer", unique=true)
     */
    private $idSubscribe;


    /**
     * @ORM\Column(name="finished_date", type="datetime", nullable=true)
     */
    private $finishedDate;


/////////////////////////////////////////////////


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finishedDate = new \DateTime();
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
     * Set idSubscribe
     *
     * @param integer $idSubscribe
     *
     * @return Success
     */
    public function setIdSubscribe($idSubscribe)
    {
        $this->idSubscribe = $idSubscribe;

        return $this;
    }

    /**
     * Get idSubscribe
     *
     * @return integer
     */
    public function getIdSubscribe()
    {
        return $this->idSubscribe;
    }

    /**
     * Set finishedDate
     *
     * @param \DateTime $finishedDate
     *
     * @return Success
     */
    public function setFinishedDate($finishedDate)
    {
        $this->finishedDate = $finishedDate;

        return $this;
    }

    /**
     * Get finishedDate
     *
     * @return \DateTime
     */
    public function getFinishedDate()
    {
        return $this->finishedDate;
    }

    /**
     * Set idUser
     *
     * @param \TmBundle\Entity\User $idUser
     *
     * @return Success
     */
    public function setIdUser(\TmBundle\Entity\User $idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \TmBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idTask
     *
     * @param \TmBundle\Entity\Task $idTask
     *
     * @return Success
     */
    public function setIdTask(\TmBundle\Entity\Task $idTask)
    {
        $this->idTask = $idTask;

        return $this;
    }

    /**
     * Get idTask
     *
     * @return \TmBundle\Entity\Task
     */
    public function getIdTask()
    {
        return $this->idTask;
    }
}
