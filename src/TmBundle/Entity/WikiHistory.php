<?php

namespace AppBundle\Entity;

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
     * @var \AppBundle\Entity\WikiArticle
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
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
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
     * @param \AppBundle\Entity\WikiArticle $wikiarticle
     *
     * @return Wikihistory
     */
    public function setWikiarticle(\AppBundle\Entity\WikiArticle $wikiarticle = null)
    {
        $this->wikiarticle = $wikiarticle;

        return $this;
    }

    /**
     * Get wikiarticle
     *
     * @return \AppBundle\Entity\WikiArticle
     */
    public function getWikiarticle()
    {
        return $this->wikiarticle;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Wikihistory
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
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
