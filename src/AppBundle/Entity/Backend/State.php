<?php

namespace AppBundle\Entity\Backend;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class State
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
     *
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="state")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="state", cascade={"all"}  )
     */
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="state", cascade={"all"}  )
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
     * @return State
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
     * Set country
     *
     * @param Country $country
     *
     * @return State
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->city = new ArrayCollection();
    }

    /**
     * Add city
     *
     * @param City $city
     *
     * @return State
     */
    public function addCity(City $city)
    {
        $this->city[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param City $city
     */
    public function removeCity(City $city)
    {
        $this->city->removeElement($city);
    }

    /**
     * Get city
     *
     * @return Collection
     */
    public function getCity()
    {
        return $this->city;
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
     * @return State
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
