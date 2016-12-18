<?php

namespace MyJobs\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="app_application")
 * @ORM\Entity(repositoryClass="MyJobs\CoreBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

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
     * @ORM\ManyToOne(targetEntity="MyJobs\CoreBundle\Entity\Contract", cascade={"persist"})
     */
    private $contract;

    /**
     * @ORM\ManyToOne(targetEntity="MyJobs\CoreBundle\Entity\Status", cascade={"persist"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="MyJobs\CoreBundle\Entity\Company", cascade={"persist"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="MyJobs\CoreBundle\Entity\Appointment", mappedBy="application", cascade={"persist"})
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity="MyJobs\CoreBundle\Entity\Relaunch", mappedBy="application", cascade={"persist"})
     */
    private $relaunches;

    /**
     * @ORM\ManyToOne(targetEntity="MyJobs\UserBundle\Entity\User", inversedBy="applications", cascade={"persist"})
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt    = new \Datetime();
        $this->appointments = new ArrayCollection();
        $this->relaunches   = new ArrayCollection();
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
     * @return Application
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
     * Set url
     *
     * @param string $url
     *
     * @return Application
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Application
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
     * @return Application
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
     * @return Application
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
     * Set contract
     *
     * @param \MyJobs\CoreBundle\Entity\Contract $contract
     *
     * @return Application
     */
    public function setContract(\MyJobs\CoreBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \MyJobs\CoreBundle\Entity\Contract
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set status
     *
     * @param \MyJobs\CoreBundle\Entity\Status $status
     *
     * @return Application
     */
    public function setStatus(\MyJobs\CoreBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MyJobs\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set company
     *
     * @param \MyJobs\CoreBundle\Entity\Company $company
     *
     * @return Application
     */
    public function setCompany(\MyJobs\CoreBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \MyJobs\CoreBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add appointment
     *
     * @param \MyJobs\CoreBundle\Entity\Appointment $appointment
     *
     * @return Application
     */
    public function addAppointment(\MyJobs\CoreBundle\Entity\Appointment $appointment)
    {
        $this->appointments[] = $appointment;

        return $this;
    }

    /**
     * Remove appointment
     *
     * @param \MyJobs\CoreBundle\Entity\Appointment $appointment
     */
    public function removeAppointment(\MyJobs\CoreBundle\Entity\Appointment $appointment)
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
     * Add relaunch
     *
     * @param \MyJobs\CoreBundle\Entity\Relaunch $relaunch
     *
     * @return Application
     */
    public function addRelaunch(\MyJobs\CoreBundle\Entity\Relaunch $relaunch)
    {
        $this->relaunches[] = $relaunch;

        return $this;
    }

    /**
     * Remove relaunch
     *
     * @param \MyJobs\CoreBundle\Entity\Relaunch $relaunch
     */
    public function removeRelaunch(\MyJobs\CoreBundle\Entity\Relaunch $relaunch)
    {
        $this->relaunches->removeElement($relaunch);
    }

    /**
     * Get relaunches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRelaunches()
    {
        return $this->relaunches;
    }

    /**
     * Set user
     *
     * @param \MyJobs\UserBundle\Entity\User $user
     *
     * @return Application
     */
    public function setUser(\MyJobs\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MyJobs\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
