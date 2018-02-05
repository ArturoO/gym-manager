<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\EventHour;
use AppBundle\Service\Notify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$repository = $this->getDoctrine()->getRepository(EventHour::class);
		
		$query = $repository->createQueryBuilder('eh')			
			->orderBy('eh.day, eh.start, eh.end', 'asc')	
			->getQuery();
		$eventHours = $query->getResult();
		
		$days = [
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday',
			'Sunday',
		];
		
		$collapsibleAreaArray = array(
			array(
				'class' => 'closed',
				'content' => 'Sed sagittis nunc diam, mattis molestie neque vehicula eu. In ut eleifend nisl. Mauris eu nisl ultricies, auctor lacus in, suscipit leo. Suspendisse at lacus sit amet lacus scelerisque congue vel ac ex. Etiam eget orci pharetra, egestas velit sed, pharetra tellus. Duis rhoncus nisl vel luctus auctor. Nunc porttitor, risus ultricies egestas faucibus, lacus eros eleifend justo, at mattis turpis dui lobortis tellus. ',
			),
			array(
				'class' => 'opened',
				'content' => 'Fusce finibus diam ut nunc fermentum elementum. Sed lectus arcu, elementum volutpat ligula ac, vulputate scelerisque risus. Etiam vitae tellus eleifend, lacinia ante in, auctor dolor. Nam tempus fermentum ante pretium commodo. Duis ut imperdiet dolor. Nunc ullamcorper, velit eget maximus sodales, lectus ligula vulputate augue, quis congue massa risus vel turpis. Aenean id sagittis metus, in accumsan augue. Pellentesque feugiat eleifend bibendum. ',
			),
		);
		
        return $this->render('default/index.html.twig', array(
            'eventHours' => $eventHours,
			'days' => $days,
			'collapsibleAreaArray' => [],
        ));
    }
	
}
