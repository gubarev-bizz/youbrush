<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Backend\State;

class AddStateFieldSubscriber implements EventSubscriberInterface
{

    private $factory;


    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        ];
    }


    private function addStateForm($form, $state)
    {
        $form->add($this->factory->createNamed('state','entity', null, array(
            'class'         => 'AppBundle:Bundle/State',
            'query_builder' => function (EntityRepository $repository) use ($state) {
                $qb = $repository->createQueryBuilder('state')
                    ->innerJoin('state.user', 'user');
                if ($state instanceof State) {
                    $qb->where('city.province = :province')
                        ->setParameter('province', $state);
                } elseif (is_numeric($state)) {
                    $qb->where('province.id = :province')
                        ->setParameter('province', $state);
                } else {
                    $qb->where('province.name = :province')
                        ->setParameter('province', null);
                }

                return $qb;
            }
        )));
    }



}