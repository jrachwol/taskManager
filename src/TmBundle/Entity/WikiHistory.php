<?php

namespace TmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WikiHistory
 *
 * @ORM\Table(name="wiki_history", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_WikiHistory_User1_idx", columns={"User_id"}), @ORM\Index(name="fk_WikiHistory_WikiArticle1_idx", columns={"wiki_article_id"})})
 * @ORM\Entity
 */
class WikiHistory {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var \TmBundle\Entity\WikiArticle
     *
     * @ORM\ManyToOne(targetEntity="WikiArticle")
     *
     * @ORM\JoinColumn(
     *      name = "wiki_article_id",
     *      referencedColumnName = "id"
     * )
     *
     */
    private $wikiarticle;

    /**
     * @var \TmBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="TmBundle\Entity\User")
     *
     * @ORM\JoinColumn(
     *      name = "user_id",
     *      referencedColumnName = "id"
     * )
     */
    private $user;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;


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
     * Set wikiarticle
     *
     * @param \TmBundle\Entity\WikiArticle $wikiarticle
     *
     * @return Wikihistory
     */
    public function setWikiarticle(\TmBundle\Entity\WikiArticle $wikiarticle = null)
    {
        $this->wikiarticle = $wikiarticle;

        return $this;
    }

    /**
     * Get wikiarticle
     *
     * @return \TmBundle\Entity\WikiArticle
     */
    public function getWikiarticle()
    {
        return $this->wikiarticle;
    }

    /**
     * Set user
     *
     * @param \TmBundle\Entity\User $user
     *
     * @return Wikihistory
     */
    public function setUser(\TmBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TmBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Wikihistory
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
}
