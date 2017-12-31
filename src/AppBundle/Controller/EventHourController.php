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

class EventHourController extends Controller
{
	/**
     * @Route("/events", name="view_events")
     */
//    public function viewEventsAction(Request $request)
//    {
//		$repository = $this->getDoctrine()->getRepository(Event::class);		
//		$events = $repository->findAll();
//		return $this->render('event/list.html.twig', array(			
//            'events' => $events,
//        ));
//	}
	
	/**
     * @Route("/event/{id}", name="view_event", requirements={"id"="\d+"})
     */
//    public function viewEventAction(Request $request, $id)
//    {
//		//fetch event from DB
//		$Event = $this->getDoctrine()
//			->getRepository(Event::class)
//			->find($id);
//		
//		return $this->render('event/view.html.twig', array(			
//            'event' => $Event,
//        ));
//	}
	
	/**
     * @Route("/event-hour/create/{event_id}", name="create_event_hour"), requirements={"event_id"="\d+"})
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
			$Event = $this->getDoctrine()
				->getRepository(Event::class)
				->find($event_id);
			
			$EventHour = $form->getData();
			
			$duration = Utils::datetime_diff_minutes($EventHour->getEnd(), $EventHour->getStart());
			$EventHour->setDuration($duration)
				->setEvent($Event);

//			echo '<pre>';
//			var_dump($EventHour);
//			die;
			
			//calculate duration

			$em = $this->getDoctrine()->getManager();
			$em->persist($EventHour);
			$em->flush();
			
			//add flash message and redirect to event list
			$this->addFlash(
				'event-notice',
				'Event Hour has been added'
			);
			return $this->redirectToRoute('view_events');
		}
		
        return $this->render('event_hour/create.html.twig', array(			
            'form' => $form->createView(),
        ));
	}
	
	/**
     * @Route("/event/edit/{id}", name="edit_event", requirements={"id"="\d+"})
     */
//    public function editEventAction(Request $request, $id)
//    {
//		//fetch event from DB
//		$Event = $this->getDoctrine()
//			->getRepository(Event::class)
//			->find($id);
//
//		$form = $this->createForm(EventType::class, $Event);
//		
//		$form->handleRequest($request);
////
//		if($form->isSubmitted() && $form->isValid()) {
//			$Event = $form->getData();
//			
//			$em = $this->getDoctrine()->getManager();
//			$em->flush();
//			
//			//add flash message and redirect to event list
//			$this->addFlash(
//				'event-notice',
//				'Event has been changed'
//			);
//			return $this->redirectToRoute('view_events');
//		}
//		
//        return $this->render('event/edit.html.twig', array(			
//            'form' => $form->createView(),
//        ));
//	}
	
	/**
     * @Route("/delete/edit/{id}", name="delete_event", requirements={"id"="\d+"})
     */
//    public function deleteEventAction(Request $request, $id)
//    {
//		//fetch event from DB
//		$Event = $this->getDoctrine()
//			->getRepository(Event::class)
//			->find($id);
//	
//		$em = $this->getDoctrine()->getManager();
//		
//		$em->remove($Event);
//		$em->flush();
//		
//		//add flash message and redirect to event list
//			$this->addFlash(
//			'event-notice',
//			'Event has been deleted'
//		);
//		return $this->redirectToRoute('view_events');
//	}
	
}
