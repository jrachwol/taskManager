<?php

namespace TmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="task")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     *
     * @Assert\NotBlank()
     */
    private $title;


    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "autor",
     *      referencedColumnName = "id"
     * )
     */
    private $author;


    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     */
    private $description;


    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $level;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * @ORM\ManyToMany(
     *     targetEntity="Tag",
     *     inversedBy="tasks"
     * )
     *
     * @ORM\JoinTable(
     *     name="task_tag"
     * )
     */
    private $tags;


/////////////////////////////////////////////////


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Task
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Task
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param \TmBundle\Entity\User $author
     *
     * @return Task
     */
    public function setAuthor(\TmBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \TmBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add tag
     *
     * @param \TmBundle\Entity\Tag $tag
     *
     * @return Task
     */
    public function addTag(\TmBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \TmBundle\Entity\Tag $tag
     */
    public function removeTag(\TmBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
