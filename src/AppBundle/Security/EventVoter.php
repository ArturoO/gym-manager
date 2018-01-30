<?php
namespace AppBundle\Security;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends Voter
{
    // these strings are just invented: you can use anything
//    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        // only vote on Event objects inside this voter
        if (!$subject instanceof Event) {
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
        /** @var Event $event */
        $event = $subject;

        switch ($attribute) {
//            case self::VIEW:
//                return $this->canView($post, $user);
            case self::EDIT:
                return $this->canEdit($event, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

//    private function canView(Post $post, User $user)
//    {
//        // if they can edit, they can view
//        if ($this->canEdit($post, $user)) {
//            return true;
//        }
//
//        // the Post object could have, for example, a method isPrivate()
//        // that checks a boolean $private property
//        return !$post->isPrivate();
//    }

    private function canEdit(Event $event, User $user)
    {
		//is current user is administrator, then 
		if(in_array('ROLE_ADMIN', $user->getRoles()))
			return true;
		
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $event->getAuthor();
    }
}