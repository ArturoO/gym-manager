<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
		$user = new User();
		$form = $this->createFormBuilder()
			->add('display_name', TextType::class)
			->add('username', TextType::class)
			->add('email', EmailType::class)
			->add('plain_password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
			->add('register', SubmitType::class)
			->getForm();
		
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			
			//assign user data
			$formData = $form->getData();			
			$user->setDisplayName($formData['display_name'])
				->setUsername($formData['username'])
				->setEmail($formData['email'])
				->setPassword($passwordEncoder->encodePassword($user, $formData['plain_password']))
				->setRole('ROLE_USER')
				->setActive(0)
			;
			
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
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
			'display_name' => $user->getDisplayName(),
			'username' => $user->getUsername(),
			'email' => $user->getEmail(),
			'plain_password' => '',
			'role' => $user->getRole(),
		);
		
		$form = $this->createFormBuilder($defaultData)
			->add('display_name', TextType::class)
			->add('username', TextType::class)
			->add('email', EmailType::class)
			->add('plain_password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
			->add('role', ChoiceType::class, [
				'choices' => [
					'User' => 'ROLE_USER',
					'Trainer' => 'ROLE_TRAINER',
					'Manager' => 'ROLE_MANAGER',
					'Administrator' => 'ROLE_ADMIN',
				],
			])
			->add('save', SubmitType::class)
			->getForm();
		
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

			$formData = $form->getData();
			
			$user->setDisplayName($formData['display_name'])
				->setUsername($formData['username'])
				->setEmail($formData['email']);
			
			//user role can be only changed by admin or manager
			if(in_array($this->getUser()->getRole(), array('ROLE_ADMIN', 'ROLE_MANAGER')))
			{
				$user->setRole($formData['role']);
			}
			
			//set password only if it isn't empty
			if($formData['plain_password']!='')
			{
				$password = $passwordEncoder->encodePassword($user, $formData['plain_password']);
				$user->setPassword($password);
			}
				
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $id));
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
