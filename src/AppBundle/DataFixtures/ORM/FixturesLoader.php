<?php
namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;


class FixturesLoader extends DataFixtureLoader{

    /**
     * Returns an array of file paths to fixtures
     *
     * @return array<string>
     */
    protected function getFixtures()
    {
        $env = $this->container->get('kernel')->getEnvironment();
        if(in_array($env ,['test','dev'])){

            if($env=='dev'){
                $connection = $this->container->get('doctrine')->getConnection();
                $connection->exec("ALTER TABLE `user` AUTO_INCREMENT = 1;");
                $connection->exec("ALTER TABLE `skills` AUTO_INCREMENT = 1;");
                $connection->exec("ALTER TABLE `country` AUTO_INCREMENT = 1;");
                $connection->exec("ALTER TABLE `state` AUTO_INCREMENT = 1;");
                $connection->exec("ALTER TABLE `city` AUTO_INCREMENT = 1;");
            }

            return [
                __DIR__ . '/Fixtures/User.yml',
                __DIR__ . '/Fixtures/Country.yml',
                __DIR__ . '/Fixtures/State.yml',
                __DIR__ . '/Fixtures/City.yml',
                __DIR__ . '/Fixtures/Skills.yml'
            ];
        }

        return [];
    }


    public function variableName($id,$text){
        return $id.'-'.$text;
    }


}