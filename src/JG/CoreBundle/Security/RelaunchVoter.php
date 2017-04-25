<?php

namespace JG\CoreBundle\Security;

use JG\CoreBundle\Entity\Relaunch;
use JG\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class RelaunchVoter extends Voter
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
        if (!$subject instanceof Relaunch) {
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

        /** @var Relaunch $relaunch */

        $relaunch = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($relaunch, $user);
            case self::EDIT:
                return $this->canEdit($relaunch, $user);
            case self::DELETE:
                return $this->canDelete($relaunch, $user);
        }

        throw new \LogicException('Ce code ne doit pas être atteind !');
    }

    private function canShow(Relaunch $relaunch, User $user)
    {
        return $user === $relaunch->getApplication()->getUser();
    }

    private function canEdit(Relaunch $relaunch, User $user)
    {
        return $user === $relaunch->getApplication()->getUser();
    }

    private function canDelete(Relaunch $relaunch, User $user)
    {
        return $user === $relaunch->getApplication()->getUser();
    }
}
