<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Avis;

class BlogVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';

    public const DELETE = "DELETE";

    protected function supports(string $attribute, mixed $subject  ): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Article ;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                if($subject->getUtilisateur() === $user || in_array('ROLE_ADMIN', $user->getRoles())){
                    return true;
                }

                break;
            case self::VIEW:
                return true;
                break;
            case self::DELETE:
                if ($subject->getUtilisateur() === $user || in_array('ROLE_ADMIN', $user->getRoles())) {
                    return true;
                }

                break;
        }

        return false;
    }
}
