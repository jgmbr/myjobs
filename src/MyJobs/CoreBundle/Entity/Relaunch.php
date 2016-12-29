<?php

namespace MyJobs\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Relaunch
 *
 * @ORM\Table(name="app_relaunch")
 * @ORM\Entity(repositoryClass="MyJobs\CoreBundle\Repository\RelaunchRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Relaunch
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_at", type="date")
     */
    private $dateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hour_at", type="time", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="MyJobs\CoreBundle\Entity\Application", inversedBy="relaunches", cascade={"persist"})
     */
    private $application;


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
     * Set dateAt
     *
     * @param \DateTime $dateAt
     *
     * @return Relaunch
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
     * @return Relaunch
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
     * @return Relaunch
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
     * @return Relaunch
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
     * @return Relaunch
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
     * @param \MyJobs\CoreBundle\Entity\Application $application
     *
     * @return Relaunch
     */
    public function setApplication(\MyJobs\CoreBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \MyJobs\CoreBundle\Entity\Application
     */
    public function getApplication()
    {
        return $this->application;
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
