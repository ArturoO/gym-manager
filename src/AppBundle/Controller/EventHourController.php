<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Utils;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventHour;
use AppBundle\Form\EventHourType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EventHourController extends Controller
{
	
	/**
     * @Route("/event-hour/create/{event_id}", name="create_event_hour"), requirements={"event_id"="\d+"})
	 * @Security("has_role('ROLE_ADMIN')")
     */
    public function createEventHourAction(Request $request, $event_id)
    {
		$EventHour = new EventHour();
		$EventHour->setEventId($event_id)
			->setStart(new \DateTime)
			->setEnd(new \DateTime);
		
		$form = $this->createForm(EventHourType::class, $EventHour);
		
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) {
			$EventHour = $form->getData();
			
			//get associated event
			$Event = $this->getDoctrine()
				->getRepository(Event::class)
				->find($event_id);
						
			//set event hour parameters
			$EventHour->setEvent($Event);

			//save record
			$em = $this->getDoctrine()->getManager();
			$em->persist($EventHour);
			$em->flush();
			
			//add flash message and redirect to event list
			$this->addFlash(
				'event-notice',
				'Event Hour has been added'
			);
			return $this->redirectToRoute('view_event_hours', array('id' => $event_id));
		}
		
        return $this->render('event_hour/create.html.twig', array(			
            'form' => $form->createView(),
        ));
	}
	
	
	/**
     * @Route("/event-hour/edit/{id}", name="edit_event_hour"), requirements={"id"="\d+"})
	 * @Security("has_role('ROLE_ADMIN')")
     */
	public function editEventHourAction(Request $request, $id)
	{
		//fetch event from DB
		$EventHour = $this->getDoctrine()
			->getRepository(EventHour::class)
			->find($id);
		
		$event_id = $EventHour->getEvent()->getId();
		
		$form = $this->createForm(EventHourType::class, $EventHour);
		
		$form->handleRequest($request);
//
		if($form->isSubmitted() && $form->isValid()) {
			$EventHour = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$em->flush();
			
			//add flash message and redirect to event list
			$this->addFlash(
				'event-notice',
				'Event hour has been changed'
			);
//			return $this->redirectToRoute('view_events');
			return $this->redirectToRoute('view_event_hours', array('id' => $event_id));
		}
		
        return $this->render('event_hour/edit.html.twig', array(			
            'form' => $form->createView(),
        ));
		
	}
	
	/**
     * @Route("/event-hour/delete/{id}", name="delete_event_hour"), requirements={"id"="\d+"})
	 * @Security("has_role('ROLE_ADMIN')")
     */
	public function deleteEventHourAction(Request $request, $id)
	{
		$EventHour = $this->getDoctrine()
			->getRepository(EventHour::class)
			->find($id);
		
		$event_id = $EventHour->getEvent()->getId();
		
		$em = $this->getDoctrine()->getManager();
		
		$em->remove($EventHour);
		$em->flush();
		
		return $this->redirectToRoute('view_event_hours', array('id' => $event_id));
	}
	
}
