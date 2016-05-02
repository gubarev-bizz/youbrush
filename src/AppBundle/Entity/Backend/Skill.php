<?php

namespace AppBundle\Entity\Backend;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * Skill
 * @ORM\Entity
 */
class Skill implements Translatable

{
    /**
     * @var integer
     *
	 * @Gedmo\Slug(fields={"name"}, updatable=true, separator="_")
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
	 * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

	/**
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="skills")
	 */
	protected $user;

	/**
	 * @Gedmo\Locale
	 * Used locale to override Translation listener`s locale
	 * this is not a mapped field of entity metadata, just a simple property
	 */
	private $locale;

	/**
	 * Constructor
	 */
	public function __construct()
	{
	  $this->user = new ArrayCollection();
	}

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
     * @return Skill
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
    

    public function __toString()
    {
        return $this->getName();
    }


    /**
     * Get user
     *
     * @return Collection
     */
    public function getUser()
    {
        return $this->user;
    }

  /**
   * @param $locale
   */
  	public function setTranslatableLocale($locale)
	{
	  $this->locale = $locale;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser($user) {
	  $this->user = $user;
	}

}
