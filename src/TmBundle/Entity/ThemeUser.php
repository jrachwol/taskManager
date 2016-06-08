<?php

namespace TmBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="theme_user")
 * @ORM\Entity()
 */
class ThemeUser {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;


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
     * @ORM\Column(type="string", length = 20, nullable = true)
     *
     */
    private $theme;


    /**
     * @ORM\Column(type="string", length = 15, nullable = true)
     *
     */
	private $font;


    /**
     * @ORM\Column(type="string", length = 15, nullable = true)
     *
     */
    private $background;

///////////////////////////////////////


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
     * Set theme
     *
     * @param string $theme
     *
     * @return ThemeUser
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set font
     *
     * @param string $font
     *
     * @return ThemeUser
     */
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get font
     *
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return ThemeUser
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set idUser
     *
     * @param \TmBundle\Entity\User $idUser
     *
     * @return ThemeUser
     */
    public function setIdUser(\TmBundle\Entity\User $idUser = null)
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
}
