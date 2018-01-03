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
			$EventHour = $form->getData();
			
			//get associated event
			$Event = $this->getDoctrine()
				->getRepository(Event::class)
				->find($event_id);
			
			//calculate duration
			$duration = Utils::datetime_diff_minutes($EventHour->getEnd(), $EventHour->getStart());
			
			//set event hour parameters
			$EventHour->setDuration($duration)
				->setEvent($Event);

			//save record
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
	
}
