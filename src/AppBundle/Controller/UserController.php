<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
	/**
     * @Route("/users", name="users_list")
     */
    public function indexAction(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(User::class);
		
		$query = $repository->createQueryBuilder('u')			
			->orderBy('u.id', 'asc')	
			->getQuery();
		
		$users = $query->getResult();
		
		return $this->render(
            'user/list.html.twig', [
			'users' => $users,
		]);
	}
	
	/**
     * @Route("/login", name="login")
     */
	public function loginAction(Request $request, AuthenticationUtils $authUtils)
	{
		// get the login error if there is one
		$error = $authUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authUtils->getLastUsername();

		return $this->render('user/login.html.twig', array(
			'last_username' => $lastUsername,
			'error'         => $error,
		));
	}
	
    /**
     * @Route("/register", name="user_registration")
     */
	public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('users_list');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }
	
}
