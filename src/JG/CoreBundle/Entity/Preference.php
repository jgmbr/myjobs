<?php

namespace JG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Preference
 *
 * @ORM\Table(name="app_preference")
 * @ORM\Entity(repositoryClass="JG\CoreBundle\Repository\PreferenceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Preference
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
     * @var bool
     *
     * @ORM\Column(name="showCompanies", type="boolean")
     */
    private $showCompanies;

    /**
     * @var bool
     *
     * @ORM\Column(name="showApplications", type="boolean")
     */
    private $showApplications;

    /**
     * @var bool
     *
     * @ORM\Column(name="showAppointments", type="boolean")
     */
    private $showAppointments;

    /**
     * @var bool
     *
     * @ORM\Column(name="showStatistics", type="boolean")
     */
    private $showStatistics;

    /**
     * @var bool
     *
     * @ORM\Column(name="pushAlerts", type="boolean")
     */
    private $pushAlerts;

    /**
     * @var int
     *
     * @ORM\Column(name="delayAlerts", type="integer")
     */
    private $delayAlerts;

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
     * @ORM\ManyToOne(targetEntity="JG\UserBundle\Entity\User", inversedBy="preferences", cascade={"persist"})
     */
    private $user;

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
     * Set showCompanies
     *
     * @param boolean $showCompanies
     *
     * @return Preference
     */
    public function setShowCompanies($showCompanies)
    {
        $this->showCompanies = $showCompanies;

        return $this;
    }

    /**
     * Get showCompanies
     *
     * @return boolean
     */
    public function getShowCompanies()
    {
        return $this->showCompanies;
    }

    /**
     * Set showApplications
     *
     * @param boolean $showApplications
     *
     * @return Preference
     */
    public function setShowApplications($showApplications)
    {
        $this->showApplications = $showApplications;

        return $this;
    }

    /**
     * Get showApplications
     *
     * @return boolean
     */
    public function getShowApplications()
    {
        return $this->showApplications;
    }

    /**
     * Set showAppointments
     *
     * @param boolean $showAppointments
     *
     * @return Preference
     */
    public function setShowAppointments($showAppointments)
    {
        $this->showAppointments = $showAppointments;

        return $this;
    }

    /**
     * Get showAppointments
     *
     * @return boolean
     */
    public function getShowAppointments()
    {
        return $this->showAppointments;
    }

    /**
     * Set showStatistics
     *
     * @param boolean $showStatistics
     *
     * @return Preference
     */
    public function setShowStatistics($showStatistics)
    {
        $this->showStatistics = $showStatistics;

        return $this;
    }

    /**
     * Get showStatistics
     *
     * @return boolean
     */
    public function getShowStatistics()
    {
        return $this->showStatistics;
    }

    /**
     * Set pushAlerts
     *
     * @param boolean $pushAlerts
     *
     * @return Preference
     */
    public function setPushAlerts($pushAlerts)
    {
        $this->pushAlerts = $pushAlerts;

        return $this;
    }

    /**
     * Get pushAlerts
     *
     * @return boolean
     */
    public function getPushAlerts()
    {
        return $this->pushAlerts;
    }

    /**
     * Set delayAlerts
     *
     * @param integer $delayAlerts
     *
     * @return Preference
     */
    public function setDelayAlerts($delayAlerts)
    {
        $this->delayAlerts = $delayAlerts;

        return $this;
    }

    /**
     * Get delayAlerts
     *
     * @return integer
     */
    public function getDelayAlerts()
    {
        return $this->delayAlerts;
    }

    /**
     * Set user
     *
     * @param \JG\UserBundle\Entity\User $user
     *
     * @return Preference
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Preference
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
     * @return Preference
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
