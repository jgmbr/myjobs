<?php

namespace MyJobs\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="MyJobs\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastname;

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
     * @ORM\OneToMany(targetEntity="MyJobs\CoreBundle\Entity\Application", mappedBy="user", cascade={"persist"})
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="MyJobs\CoreBundle\Entity\Company", mappedBy="user", cascade={"persist"})
     */
    private $companies;

    private $role;

    private $superAdmin;

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->addRole($role);
    }

    public function __construct()
    {
        parent::__construct();
        $this->createdAt    = new \Datetime();
        $this->applications = new ArrayCollection();
        $this->companies    = new ArrayCollection();
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Add application
     *
     * @param \MyJobs\CoreBundle\Entity\Application $application
     *
     * @return User
     */
    public function addApplication(\MyJobs\CoreBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \MyJobs\CoreBundle\Entity\Application $application
     */
    public function removeApplication(\MyJobs\CoreBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add company
     *
     * @param \MyJobs\CoreBundle\Entity\Company $company
     *
     * @return User
     */
    public function addCompany(\MyJobs\CoreBundle\Entity\Company $company)
    {
        $this->companies[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param \MyJobs\CoreBundle\Entity\Company $company
     */
    public function removeCompany(\MyJobs\CoreBundle\Entity\Company $company)
    {
        $this->companies->removeElement($company);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
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
