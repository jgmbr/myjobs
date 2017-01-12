<?php

namespace JG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Preferences
 *
 * @ORM\Table(name="app_preferences")
 * @ORM\Entity(repositoryClass="JG\CoreBundle\Repository\PreferencesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Preferences
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
     * @ORM\ManyToOne(targetEntity="JG\UserBundle\Entity\User", inversedBy="preferences", cascade={"persist"})
     */
    private $user;

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
     * @return Preferences
     */
    public function setShowCompanies($showCompanies)
    {
        $this->showCompanies = $showCompanies;

        return $this;
    }

    /**
     * Get showCompanies
     *
     * @return bool
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
     * @return Preferences
     */
    public function setShowApplications($showApplications)
    {
        $this->showApplications = $showApplications;

        return $this;
    }

    /**
     * Get showApplications
     *
     * @return bool
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
     * @return Preferences
     */
    public function setShowAppointments($showAppointments)
    {
        $this->showAppointments = $showAppointments;

        return $this;
    }

    /**
     * Get showAppointments
     *
     * @return bool
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
     * @return Preferences
     */
    public function setShowStatistics($showStatistics)
    {
        $this->showStatistics = $showStatistics;

        return $this;
    }

    /**
     * Get showStatistics
     *
     * @return bool
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
     * @return Preferences
     */
    public function setPushAlerts($pushAlerts)
    {
        $this->pushAlerts = $pushAlerts;

        return $this;
    }

    /**
     * Get pushAlerts
     *
     * @return bool
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
     * @return Preferences
     */
    public function setDelayAlerts($delayAlerts)
    {
        $this->delayAlerts = $delayAlerts;

        return $this;
    }

    /**
     * Get delayAlerts
     *
     * @return int
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
     * @return Preferences
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
}
