<?php

namespace JG\CoreBundle\Security;

use JG\CoreBundle\Entity\Company;
use JG\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CompanyVoter extends Voter
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
        if (!$subject instanceof Company) {
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

        /** @var Company $company */

        $company = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($company, $user);
            case self::EDIT:
                return $this->canEdit($company, $user);
            case self::DELETE:
                return $this->canDelete($company, $user);
        }

        throw new \LogicException('Ce code ne doit pas être atteind !');
    }

    private function canShow(Company $company, User $user)
    {
        return $user === $company->getUser();
    }

    private function canEdit(Company $company, User $user)
    {
        return $user === $company->getUser();
    }

    private function canDelete(Company $company, User $user)
    {
        return $user === $company->getUser();
    }
}
