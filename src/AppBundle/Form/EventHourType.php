<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventHourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('start', DateTimeType::class, array(
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
			))
			->add('end', DateTimeType::class, array(
				'date_widget' => 'single_text', 
				'time_widget' => 'single_text',
			))
            ->add('description', TextareaType::class)
			->add('location', TextType::class)
			->add('event_id', HiddenType::class)
            ->add('save', SubmitType::class)
        ;
    }
}