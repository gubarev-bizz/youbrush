<?php

namespace AppBundle\Entity\Backend;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Skill
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

	/**
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="skills")
	 */
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->user = new ArrayCollection();
		$this->translations = new ArrayCollection();
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


	/**
	 * @return string
	 */
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
	 * @param mixed $user
	 */
	public function setUser($user)
    {
	  $this->user = $user;
	}

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param SkillTranslation $t
     */
    public function addTranslation(SkillTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

}
