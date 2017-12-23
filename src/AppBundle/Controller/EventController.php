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
			
			//add flash message and redirect to event list
			$this->addFlash(
				'event-notice',
				'Event has been added'
			);
			return $this->redirectToRoute('view_events');
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
	
	
}
