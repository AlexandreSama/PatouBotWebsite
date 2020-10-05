<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre",
                'required' => true
            ])
            ->add('subject', TextType::class, [
                'label' => "Sujet",
                'required' => true
            ])
            ->add('label', ChoiceType::class, [
                'choices' => [
                    'Technique' => [
                        'Bug' => 'Bug',
                        'Report' => 'Report',
                    ],
                    'Installation' => [
                        'Erreurs' => 'Errors',
                        'Crashs' => 'Crashs',
                    ],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
