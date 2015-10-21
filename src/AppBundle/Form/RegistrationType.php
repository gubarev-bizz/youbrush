<?php

namespace AppBundle\Form;

use AppBundle\Entity\State;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', ['required' => true, 'label'=>'Email'])
            ->add('name', 'text', ['required' => true, 'label'=>'Full name'])
            ->add('plain_password', 'repeated', [
                'required' => true,
                'property_path' => 'plainPassword',
                'options' => [
                    'attr' => [
                        'class' => 'password-field',
                        'name' => 'plainPassword'
                    ]
                ],
                'type' => 'password',
                'first_name' => 'password',
                'second_name' => 'confirmPassword',
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('skills', null, ['required' => false])
            ->add('country', 'entity', [
                'class' => 'AppBundle:Country',
                'required' => true
            ])
        ;
            /*
            ->add('state', 'entity', array(
                'class' => 'AppBundle:State',
                'multiple' => false,
                'required' => true,
                'mapped' => true,
                'empty_value' => '-- sélectionner un ensemble --',
            ))
            */



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'method' => 'POST',
        ));
    }

    public function getName()
    {
        return 'appbundle_registration';
    }
}