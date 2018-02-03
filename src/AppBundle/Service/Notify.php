<?php

namespace AppBundle\Service;

class Notify
{
	
	public function newUser($userId)
	{
		return 1;
		//get administrator
		$repository = $doctrine->getRepository(User::class);
		$query = $repository->createQueryBuilder('u')
			->where('u.role = :role')
			->setParameter('role', 'ROLE_ADMIN')
			->getQuery();
		$user = $query->getResult();
		
		dump($user);
		die;
		
		return true;
		
		//get new registered user
		
		
		$message = (new \Swift_Message('Hello Email'))
			->setFrom('postmaster@localhost')
			->setTo(array(
				'postslave@localhost',
			))
			->setBody(
				'something simple',
				'text/html'
			)
		;
		$mailer->send($message);

		return new Response(
            '<html><body>Success</body></html>'
        );
	}
	
}
