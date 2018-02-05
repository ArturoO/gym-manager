<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Notify
{
	private $mailer;
	
	private $em;
	
	private $twig;
	
	public function __construct(\Swift_Mailer $mailer, EntityManagerInterface $em, \Twig_Environment $twig)
	{
		$this->mailer = $mailer;
		$this->em = $em;
		$this->twig = $twig;
	}
	
	public function newUser($userId)
	{
		$userRepository = $this->em->getRepository(User::class);
		
		//get administrator
		$query = $userRepository->createQueryBuilder('u')
			->where('u.role = :role')
			->setParameter('role', 'ROLE_ADMIN')
			->getQuery();
		$admin = $query->getSingleResult();
		
		//get registered user
		$user = $userRepository->find($userId);
				
		$message = (new \Swift_Message('New user'))
			->setFrom('postmaster@localhost')
			->setTo($admin->getEmail())
			->setBody(
				$this->twig->render(
					'email/new-user.html.twig',
					array('user' => $user)
				),
				'text/html'
			)
		;
		$this->mailer->send($message);
		
		return true;
	}
	
}
