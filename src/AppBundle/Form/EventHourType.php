<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('start', TimeType::class, [
				'widget' => 'single_text',				
			])
			->add('end', TimeType::class, [
				'widget' => 'single_text',
			])
			->add('day', ChoiceType::class, [
				'choices' => [
					'Monday' => 1,
					'Tuesday' => 2,
					'Wednesday' => 3,
					'Thursday' => 4,
					'Friday' => 5,
					'Saturday' => 6,
					'Sunday' => 7,
				]
			])
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class)
        ;
    }
}