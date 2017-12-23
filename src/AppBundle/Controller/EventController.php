<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
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
     * @Route("/event/edit/{id}", name="edit_event", requirements={"id"="\d+"})
     */
    public function editEventAction(Request $request, $id)
    {
		
		//fetch event from DB
		$Event = $this->getDoctrine()
			->getRepository(Event::class)
			->find($id);

		$form = $this->createForm(EventType::class, $Event);
		
		$form->handleRequest($request);
//
		if($form->isSubmitted() && $form->isValid()) {
			$Event = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$em->flush();
			
			//add flash message and redirect to event list
			$this->addFlash(
				'event-notice',
				'Event has been changed'
			);
			return $this->redirectToRoute('view_events');
		}
		
        return $this->render('event/edit.html.twig', array(			
            'form' => $form->createView(),
        ));
	}
	
	/**
     * @Route("/delete/edit/{id}", name="delete_event", requirements={"id"="\d+"})
     */
    public function deleteEventAction(Request $request, $id)
    {
		//fetch event from DB
		$Event = $this->getDoctrine()
			->getRepository(Event::class)
			->find($id);
	
		$em = $this->getDoctrine()->getManager();
		
		$em->remove($Event);
		$em->flush();
		
		//add flash message and redirect to event list
			$this->addFlash(
			'event-notice',
			'Event has been deleted'
		);
		return $this->redirectToRoute('view_events');
	}
	
}
