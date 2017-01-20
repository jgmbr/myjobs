<?php

namespace JG\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="JG\UserBundle\Repository\UserRepository")
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
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Application", mappedBy="user", cascade={"persist"})
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Company", mappedBy="user", cascade={"persist"})
     */
    private $companies;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Appointment", mappedBy="user", cascade={"persist"})
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Preference", mappedBy="user", cascade={"persist"})
     */
    private $preferences;

    /**
     * @ORM\OneToMany(targetEntity="JG\CoreBundle\Entity\Alert", mappedBy="user", cascade={"persist"})
     */
    private $alerts;

    private $role;

    private $superAdmin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $picture;

    /**
     * @Assert\File(
     *     maxSize = "3M",
     *     maxSizeMessage = "Poids maximal de la photo : 3 mo",
     *     mimeTypes = {"image/png","image/jpg","image/jpeg"},
     *     mimeTypesMessage = "Format de la photo incorrect : PNG, JPG et JPEG autorisés",
     *     uploadErrorMessage = "Le fichier ne peut être envoyé",
     *     uploadFormSizeErrorMessage = "Le fichier est trop grand",
     *     notReadableMessage = "Le fichier n'est pas lisible",
     *     notFoundMessage = "Le fichier est introuvable"
     * )
     */
    private $file;

    private $temp;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt    = new \Datetime();
        $this->applications = new ArrayCollection();
        $this->companies    = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->preferences  = new ArrayCollection();
        $this->alerts       = new ArrayCollection();
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
     * @param \JG\CoreBundle\Entity\Application $application
     *
     * @return User
     */
    public function addApplication(\JG\CoreBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \JG\CoreBundle\Entity\Application $application
     */
    public function removeApplication(\JG\CoreBundle\Entity\Application $application)
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
     * @param \JG\CoreBundle\Entity\Company $company
     *
     * @return User
     */
    public function addCompany(\JG\CoreBundle\Entity\Company $company)
    {
        $this->companies[] = $company;

        return $this;
    }

    /**
     * Remove company
     *
     * @param \JG\CoreBundle\Entity\Company $company
     */
    public function removeCompany(\JG\CoreBundle\Entity\Company $company)
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
     * @return User
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
     * @return User
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

    public function getRole()
    {
        if (!$this->roles)
            return parent::ROLE_DEFAULT;
        else
            return $this->roles[0];
    }

    public function setRole($role)
    {
        foreach ($this->getRoles() as $currentRole)
            $this->removeRole($currentRole);

        $this->addRole($role);
    }

    /**
     * Add appointment
     *
     * @param \JG\CoreBundle\Entity\Appointment $appointment
     *
     * @return User
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
     * Add preference
     *
     * @param \JG\CoreBundle\Entity\Preference $preference
     *
     * @return User
     */
    public function addPreference(\JG\CoreBundle\Entity\Preference $preference)
    {
        $this->preferences[] = $preference;

        return $this;
    }

    /**
     * Remove preference
     *
     * @param \JG\CoreBundle\Entity\Preference $preference
     */
    public function removePreference(\JG\CoreBundle\Entity\Preference $preference)
    {
        $this->preferences->removeElement($preference);
    }

    /**
     * Get preferences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * Add alert
     *
     * @param \JG\CoreBundle\Entity\Alert $alert
     *
     * @return User
     */
    public function addAlert(\JG\CoreBundle\Entity\Alert $alert)
    {
        $this->alerts[] = $alert;

        return $this;
    }

    /**
     * Remove alert
     *
     * @param \JG\CoreBundle\Entity\Alert $alert
     */
    public function removeAlert(\JG\CoreBundle\Entity\Alert $alert)
    {
        $this->alerts->removeElement($alert);
    }

    /**
     * Get alerts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlerts()
    {
        return $this->alerts;
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

    /*
    ******************** Profile picture upload ********************
    */

    public function getAbsolutePath()
    {
        return null === $this->picture
            ? null
            : $this->getUploadRootDir().'/'.$this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture
            ? null
            : $this->getUploadDir().'/'.$this->picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/profiles';
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->setUpdatedAt(new \DateTime('now'));

        $this->file = $file;
        // check if we have an old image path
        if (isset($this->picture)) {
            // store the old name to delete after the update
            $this->temp = $this->picture;
            $this->picture = null;
        } else {
            $this->picture = 'initial';
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->picture);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->picture = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /* Threads datas */

    public function toString($data)
    {
        $str = "";
        foreach ($data as $data)
        {
            $str .= $data .",";
        }
        return trim($str, ",");
    }

    public function toArray()
    {
        return array(
            $this->id,
            $this->username,
            $this->usernameCanonical,
            $this->email,
            $this->emailCanonical,
            $this->enabled,
            utf8_decode($this->firstname),
            utf8_decode($this->lastname),
            $this->toString($this->getRoles()),
            $this->createdAt->format('d/m/Y')
        );
    }
}
