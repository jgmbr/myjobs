<?php

namespace JG\CoreBundle\Security;

use JG\CoreBundle\Entity\Application;
use JG\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApplicationVoter extends Voter
{
    const SHOW = 'show';
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::SHOW, self::EDIT, self::DELETE))) {
            return false;
        }

        // only vote on Observation objects inside this voter
        if (!$subject instanceof Application) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything on Observation! The power!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        // you know $subject is a Application object, thanks to supports

        /** @var Application $application */

        $application = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($application, $user);
            case self::EDIT:
                return $this->canEdit($application, $user);
            case self::DELETE:
                return $this->canDelete($application, $user);
        }

        throw new \LogicException('Ce code ne doit pas être atteind !');
    }

    private function canShow(Application $application, User $user)
    {
        return $user === $application->getUser();
    }

    private function canEdit(Application $application, User $user)
    {
        return $user === $application->getUser();
    }

    private function canDelete(Application $application, User $user)
    {
        return $user === $application->getUser();
    }
}
