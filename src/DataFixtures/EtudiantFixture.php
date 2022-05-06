<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager, ): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
          //  $var=range(25,61);

            $etudiant = new Etudiant();
            $etudiant->setNom($faker->name);
            $etudiant->setPrenom($faker->firstName);
            //$etudiant->setSection();
            $manager->persist($etudiant);
        }

        $manager->flush();
    }
}
