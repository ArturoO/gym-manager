<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Product;
use AppBundle\Entity\Task;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		
        return $this->render('default/index.html.twig', array(
            
        ));
    }
	
	/**
     * @Route("/phpinfo", name="php_info")
     */
    public function phpInfoAction(Request $request)
    {
		ob_start();
		phpinfo();
		$phpinfo = ob_get_clean();
		
        return $this->render('default/phpinfo.html.twig', array(
			'phpinfo' => $phpinfo,
		));
    }
	
	
	 /**
     * @Route("/create/product", name="create_product")
     */
    public function createProductAction(Request $request)
    {
        $product = new Product();
		$product->setName('Keyboard');
		$product->setPrice(19.99);
		$product->setDescription('Ergonomic and stylish!');

		$em = $this->getDoctrine()->getManager();

		// tells Doctrine you want to (eventually) save the Product (no queries yet)
		$em->persist($product);

		// actually executes the queries (i.e. the INSERT query)
		$em->flush();

		return new Response('Saved new product with id '.$product->getId());
    }
	
	/**
     * @Route("/event/create", name="create_event")
     */
    public function createEventAction(Request $request)
    {
		$Event = new Event();
		$form = $this->createForm(EventType::class, $Event);
		
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$Event = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($Event);
			$em->flush();
		}
		
        return $this->render('event/create.html.twig', array(			
            'form' => $form->createView(),
        ));
	}
	
	/**
     * @Route("/events", name="view_events")
     */
    public function viewEventsAction(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(Event::class);		
		$events = $repository->findAll();
		return $this->render('event/list.html.twig', array(			
            'events' => $events,
        ));
	}
	
	/**
     * @Route("/task/create", name="create_task")
     */
    public function createTaskAction(Request $request)
    {
        $task = new Task();
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)            
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();
		
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$task2 = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($task2);
			$em->flush();
		}
		
		$repository = $this->getDoctrine()->getRepository(Task::class);
		$tasks = $repository->findBy(array(), array('dueDate' => 'desc'));
//		$tasks = $repository->findAll();
		
        return $this->render('default/create-task.html.twig', array(
			'tasks' => $tasks,
            'form' => $form->createView(),
        ));
	}
	
	/**
     * @Route("/task/success", name="task_success")
     */
    public function taskSuccessAction(Request $request)
    {
		return new Response(
            '<html><body>Task has been added ! </body></html>'
        );
	}
	
}
