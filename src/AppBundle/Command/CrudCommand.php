<?php
namespace AppBundle\Command;

use AppBundle\Controller\MyDoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;

class CrudCommand extends GenerateDoctrineCrudCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('doctrine:generate:crud');
        $this->setDescription('Our own admin generator rocks!');
    }

    protected function createGenerator($bundle = null)
    {
        return new MyDoctrineCrudGenerator($this->getContainer()->get('filesystem'));
    }
}