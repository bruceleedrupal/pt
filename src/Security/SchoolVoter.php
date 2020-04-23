<?php
namespace App\Security;

use App\Entity\School;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class SchoolVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const NEW  = 'new';
    const DELETE  = 'delete';
    
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT ,self::NEW,self::DELETE ])) {
            return false;
        }
        
        // only vote on Post objects inside this voter
        if (!$subject instanceof School) {
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
        $school = $subject;
        
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($school, $user);
            case self::EDIT:
                return $this->canEdit($school, $user);
            case self::NEW:
                return $this->canCreate($user);
            case self::DELETE:
                return $this->canDelete($school,$user);
        }       
       
    }
    
    private function canView(School $school, User $user)
    {
        return true;
    }
    
    private function canEdit(School $school, User $user)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }        
        
        return $user === $school->getAgent();
    }
    
    private function canCreate(User $user)
    {
        return $this->security->isGranted('ROLE_AGENT');
    }
    
    private function canDelete(School $school, User $user)
    {
        return $this->canEdit($school, $user);
    }
}