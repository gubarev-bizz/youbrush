<?php

namespace AppBundle\Entity\Backend;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;

/**
 * Skill
 *
 * @ORM\Table()
 * @Gedmo\TranslationEntity(class="Entity\CategoryTranslation")
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
	 * @Gedmo\Locale
	 * Used locale to override Translation listener`s locale
	 * this is not a mapped field of entity metadata, just a simple property
	 */
	private $locale;


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
     * Constructor
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Skill
     */
    public function addUser(User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->user->removeElement($user);
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

}
