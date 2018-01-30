<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
	
	/**
     * @Route("/user/edit/{id}", name="user_edit", requirements={"id"="\d+"})
     */
	public function editAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
		$id = $request->get('id');
		//fetch user from DB
		$user = $this->getDoctrine()
			->getRepository(User::class)
			->find($id);
		
		$oldRole = $user->getRole();
		
		// 1) build the form
		$defaultData = array(
			'username' => $user->getUsername(),
			'role' => $user->getRole(),
		);
		
		$form = $this->createFormBuilder($defaultData)
			->add('username', TextType::class)
			->add('role', ChoiceType::class, [
				'choices' => [
					'User' => 'ROLE_USER',
					'Trainer' => 'ROLE_TRAINER',
					'Manager' => 'ROLE_MANAGER',
					'Administrator' => 'ROLE_ADMIN',
				],
			])
			->getForm();
		
		
//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

			$formData = $form->getData();
			
			$user->setUsername($formData['username'])
				->setRole($formData['role'])				
			;
			
            // 3) Encode the password (you could also do this via Doctrine listener)
//            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
//            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('users_list');
        }

        return $this->render(
            'user/edit.html.twig',
            array('form' => $form->createView())
        );
	}
	
	/**
     * @Route("/user/delete/{id}", name="user_delete", requirements={"id"="\d+"})
     */
	public function deleteAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
		
	}
	
}
