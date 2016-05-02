<?php

namespace AppBundle\Entity\Backend;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Country
{
    /**
     * @var integer
     *
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
     * @ORM\OneToMany(targetEntity="State", mappedBy="country", cascade={"all"}  )
     */
    protected $state;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="country", cascade={"all"}  )
     */
    protected $user;

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
     * @return Country
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
     * Constructor
     */
    public function __construct()
    {
        $this->state = new ArrayCollection();
    }

    /**
     * Add state
     *
     * @param State $state
     *
     * @return Country
     */
    public function addState(State $state)
    {
        $this->state[] = $state;

        return $this;
    }

    /**
     * Remove state
     *
     * @param State $state
     */
    public function removeState(State $state)
    {
        $this->state->removeElement($state);
    }

    /**
     * Get state
     *
     * @return Collection
     */
    public function getState()
    {
        return $this->state;
    }

    public function __toString()
    {
        return $this->getName();
    }


    /**
     * Add user
     *
     * @param User $user
     *
     * @return Country
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
        $this->getUser()->removeElement($user);
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
}
