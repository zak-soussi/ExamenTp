<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager, ): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {


            $section = new Section();
            $section->setDesignation($faker->streetName);

            $manager->persist($section);


            for ($j = 0; $j < 10; $j++) {


                $etudiant = new Etudiant();
                $etudiant->setNom($faker->name);
                $etudiant->setPrenom($faker->firstName);
                $etudiant->setSection($section);
                $manager->persist($etudiant);
            }

        }
        for ($j = 0; $j < 10; $j++) {


            $etudiant = new Etudiant();
            $etudiant->setNom($faker->name);
            $etudiant->setPrenom($faker->firstName);

            $manager->persist($etudiant);
        }
        $manager->flush();

    }
}
