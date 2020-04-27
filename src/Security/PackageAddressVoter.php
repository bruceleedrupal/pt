<?php
namespace App\Security;

use App\Entity\PackageAddress;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use App\Service\SchoolSessionStorage;

class PackageAddressVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const NEW  = 'new';
    const DELETE  = 'delete';
    private $schoolSessionStorage;
    
    private $security;
    
    public function __construct(Security $security,SchoolSessionStorage $schoolSessionStorage)
    {
        $this->security = $security;
        $this->schoolSessionStorage = $schoolSessionStorage;
    }
    
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT ,self::NEW,self::DELETE ])) {
            return false;
        }
        
        // only vote on Post objects inside this voter
        if (!$subject instanceof PackageAddress) {
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
        
        // you know $subject is a Post object, thanks to supports
        /** @var Post $post */
        $packageAddress = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($packageAddress, $user);
            case self::EDIT:
                return $this->canEdit($packageAddress, $user);
            case self::NEW:
                return $this->canCreate($user);
            case self::DELETE:
                return $this->canDelete($packageAddress,$user);
        }       
       
    }
    
    private function canView(PackageAddress $packageAddress, User $user)
    {
        return true;
    }
    
    private function canEdit(PackageAddress $packageAddress, User $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }        
        
        return $user === $packageAddress->getSchool()->getAgent();
    }
    
    private function canCreate(User $user)
    {
        return $this->security->isGranted('ROLE_AGENT') && $this->schoolSessionStorage->getSelectedSchool();
    }
    
    private function canDelete(PackageAddress $packageAddress, User $user)
    {
        return $this->canEdit($packageAddress, $user);
    }
}
