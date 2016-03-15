<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\Skills;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', ['required' => true])
            ->add('name', 'text', ['label' => 'Full name', 'required' => true])
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
            ->add('image', 'file', [
                'required' => false,
                'label' => 'Photo'
            ])
            ->add('skills', null, [
                'property' => 'name',
                'required'    => true,
            ])
            ->add('type', 'choice', [
                'label' => 'Role user',
                'choices' => [
                    USER::ROLE_ADMIN => USER::ROLE_ADMIN,
                    USER::ROLE_MANAGER => USER::ROLE_MANAGER,
                    USER::ROLE_USER => USER::ROLE_USER
                ],
                'required' => true
            ])
            ->add('status', 'checkbox', ['label' => 'Active', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'appbundle_user';
    }
}