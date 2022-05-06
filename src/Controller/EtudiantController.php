<?php

namespace App\Controller;

use App\Entity\Section;


use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant/all', name: 'etudiant.all')]
    public function index(ObjectManager $doctrine): Response
    {
        $manager=$doctrine->getRepository(Section::class);
        $all=$manager->findAll();

        return $this->render('etudiant/index.html.twig', [
            "alls"=>$all
        ]);
    }
}
