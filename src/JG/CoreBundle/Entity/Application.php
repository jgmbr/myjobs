<?php

namespace JG\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="app_application")
 * @ORM\Entity(repositoryClass="JG\CoreBundle\Repository\ApplicationRepository")
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
     * @ORM\ManyToOne(targetEntity="JG\CoreBundle\Entity\Contract", cascade={"persist"})
     */
    private $contract;

    /**
     * @ORM\ManyToOne(targetEntity="JG\CoreBundle\Entity\Status", cascade={"persist"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="JG\CoreBundle\Entity\Company", cascade={"persist"})
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Appointment", mappedBy="application", cascade={"persist"})
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Relaunch", mappedBy="application", cascade={"persist"})
     */
    private $relaunches;

    /**
     * @ORM\ManyToOne(targetEntity="JG\UserBundle\Entity\User", inversedBy="applications", cascade={"persist"})
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
     * Constructor
     */
    public function __construct()
    {
        $this->appointments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->relaunches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set contract
     *
     * @param \JG\CoreBundle\Entity\Contract $contract
     *
     * @return Application
     */
    public function setContract(\JG\CoreBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \JG\CoreBundle\Entity\Contract
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set status
     *
     * @param \JG\CoreBundle\Entity\Status $status
     *
     * @return Application
     */
    public function setStatus(\JG\CoreBundle\Entity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \JG\CoreBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set company
     *
     * @param \JG\CoreBundle\Entity\Company $company
     *
     * @return Application
     */
    public function setCompany(\JG\CoreBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \JG\CoreBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Add appointment
     *
     * @param \JG\CoreBundle\Entity\Appointment $appointment
     *
     * @return Application
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
     * Add relaunch
     *
     * @param \JG\CoreBundle\Entity\Relaunch $relaunch
     *
     * @return Application
     */
    public function addRelaunch(\JG\CoreBundle\Entity\Relaunch $relaunch)
    {
        $this->relaunches[] = $relaunch;

        return $this;
    }

    /**
     * Remove relaunch
     *
     * @param \JG\CoreBundle\Entity\Relaunch $relaunch
     */
    public function removeRelaunch(\JG\CoreBundle\Entity\Relaunch $relaunch)
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
     * @param \JG\UserBundle\Entity\User $user
     *
     * @return Application
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
