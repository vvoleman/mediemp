<?php

namespace App\Security\Voter;

use App\Entity\Admin;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EmployerVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        if(!in_array($attribute, ['EMPLOYEE_IS_MANAGER','EMPLOYEE_MANAGER_OF'])){
            return false;
        }

        if($subject){
            return $subject instanceof Employer;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser()->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof Employee) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EMPLOYEE_IS_MANAGER':
                return $user->getManaging() != null;
            case 'EMPLOYEE_MANAGER_OF':
                return $user->getManaging()->getId() === $subject;
        }

        return false;
    }
}
