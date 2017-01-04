<?php

namespace JG\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * State
 *
 * @ORM\Table(name="app_state")
 * @ORM\Entity(repositoryClass="JG\CoreBundle\Repository\StateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class State
{
    /**
     * @var int
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
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7)
     */
    private $color;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Appointment", mappedBy="state", cascade={"persist"})
     */
    private $appointments;

    public function __construct()
    {
        $this->createdAt    = new \Datetime();
        $this->appointments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
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
     * Set color
     *
     * @param string $color
     *
     * @return State
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return State
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return State
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add appointment
     *
     * @param \JG\CoreBundle\Entity\Appointment $appointment
     *
     * @return State
     */
    public function addAppointment(\JG\CoreBundle\Entity\Appointment $appointment)
    {
        $this->appointments[] = $appointment;

        return $this;
    }

    /**
     * Remove appointment
     *
     * @param \JG\CoreBundle\Entity\Appointment $appointment
     */
    public function removeAppointment(\JG\CoreBundle\Entity\Appointment $appointment)
    {
        $this->appointments->removeElement($appointment);
    }

    /**
     * Get appointments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppointments()
    {
        return $this->appointments;
    }

    /**
     * Triggered on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Triggered on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
