<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Route("/event/{id}", name="view_event", requirements={"id"="\d+"})
     */
    public function viewEventAction(Request $request, $id)
    {
		//fetch event from DB
		$Event = $this->getDoctrine()
			->getRepository(Event::class)
			->find($id);
		
		return $this->render('event/view.html.twig', array(			
            'event' => $Event,
        ));
	}
	
	/**
     * @Route("/event/{id}/hours", name="view_event_hours", requirements={"id"="\d+"})
	 * @Security("has_role('ROLE_ADMIN')")
     */
    public function viewEventHoursAction(Request $request, $id)
    {
		//fetch event from DB
		$Event = $this->getDoctrine()
			->getRepository(Event::class)
			->find($id);
		$hours = $Event->getEventHours();
		
		return $this->render('event/hours.html.twig', array(			
            'event' => $Event,
			'hours' => $hours,
        ));
	}
	
	/**
     * @Route("/event/create", name="create_event")
	 * @Security("has_role('ROLE_ADMIN')")
     */
    public function createEventAction(Request $request)
    {
		$Event = new Event();
		$form = $this->createForm(EventType::class, $Event);
		
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$Event = $form->getData();
			
			//set author
			$Event->setAuthor($this->getUser());
			
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
	 * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/event/delete/{id}", name="delete_event", requirements={"id"="\d+"})
	 * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteEventAction(Request $request, $id)
    {
		//fetch event from DB
		$Event = $this->getDoctrine()
			->getRepository(Event::class)
			->find($id);
		
		$em = $this->getDoctrine()->getManager();
		
		//fetch event hours and delete them.
		$hours = $Event->getEventHours();
		foreach($hours as $hour)
			$em->remove($hour);
		//delete the event
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
