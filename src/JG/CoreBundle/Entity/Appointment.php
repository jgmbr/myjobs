<?php

namespace JG\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Appointment
 *
 * @ORM\Table(name="app_appointment")
 * @ORM\Entity(repositoryClass="JG\CoreBundle\Repository\AppointmentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Appointment
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
     * @Assert\NotBlank(
     *     message="Veuillez renseigner un nom d'entretien"
     * )
     *
     * @Assert\Length(
     *     min = 2,
     *     max = 255,
     *     minMessage = "Le nom d'entretien doit contenir au moins 2 caractères",
     *     maxMessage = "Le nom d'entretien doit contenir au maximum 255 caractères"
     * )
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank(
     *     message="Veuillez renseigner une date de candidature"
     * )
     *
     * @ORM\Column(name="date_at", type="date")
     */
    private $dateAt;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank(
     *     message="Veuillez renseigner une heure de candidature"
     * )
     *
     * @ORM\Column(name="hour_at", type="time")
     */
    private $hourAt;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

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
     * @ORM\ManyToOne(targetEntity="JG\CoreBundle\Entity\Application", inversedBy="appointments", cascade={"persist"})
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="JG\UserBundle\Entity\User", inversedBy="appoitments", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="JG\CoreBundle\Entity\State", inversedBy="appointments", cascade={"persist"})
     */
    private $state;

    public function __construct()
    {
        $this->createdAt    = new \Datetime();
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
     * @return Appointment
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
     * Set dateAt
     *
     * @param \DateTime $dateAt
     *
     * @return Appointment
     */
    public function setDateAt($dateAt)
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    /**
     * Get dateAt
     *
     * @return \DateTime
     */
    public function getDateAt()
    {
        return $this->dateAt;
    }

    /**
     * Set hourAt
     *
     * @param \DateTime $hourAt
     *
     * @return Appointment
     */
    public function setHourAt($hourAt)
    {
        $this->hourAt = $hourAt;

        return $this;
    }

    /**
     * Get hourAt
     *
     * @return \DateTime
     */
    public function getHourAt()
    {
        return $this->hourAt;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Appointment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Appointment
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
     * @return Appointment
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
     * Set application
     *
     * @param \JG\CoreBundle\Entity\Application $application
     *
     * @return Appointment
     */
    public function setApplication(\JG\CoreBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \JG\CoreBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set user
     *
     * @param \JG\UserBundle\Entity\User $user
     *
     * @return Appointment
     */
    public function setUser(\JG\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \JG\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set state
     *
     * @param \JG\CoreBundle\Entity\State $state
     *
     * @return Appointment
     */
    public function setState(\JG\CoreBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \JG\CoreBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
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
