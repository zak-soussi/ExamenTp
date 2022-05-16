<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[
    Route('etudiants')
]
class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }

    #[
        Route('', name: 'etudiant.list')
    ]
    public function list(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Etudiant::class);

        $etudiants = $repository->findBy([]);

        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
            'isPaginated' => true,
        ]);
    }

    #[Route('/edit/{id?0}', name: 'etudiant.edit')]
    public function addPersonne(Etudiant $etudiant = null, ManagerRegistry $doctrine, Request $request): Response
    {
        $new = false;
        //$this->getDoctrine() : Version Sf <= 5
        if (!$etudiant) {
            $new = true;
            $etudiant = new Etudiant();
        }


        $form = $this->createForm(EtudiantType::class, $etudiant);

        $form->handleRequest($request);

        if($form->isSubmitted()) {

            $manager = $doctrine->getManager();
            $manager->persist($etudiant);

            $manager->flush();
            // Afficher un mssage de succès
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash('success',$etudiant->getNom(). $message );
            // Rediriger verts la liste des etudiant
            return $this->redirectToRoute('etudiant.list');
        } else {
            //Sinon
            //On affiche notre formulaire
            return $this->render('etudiant/add-etudiant.html.twig', [
                'form' => $form->createView()
            ]);
        }

    }

    #[Route('/delete/{id}', name: 'etudiant.delete')]
    public function deletePersonne(Etudiant $etudiant = null, ManagerRegistry $doctrine): RedirectResponse {
        // Récupérer la etudiant
        if ($etudiant) {
            // Si la etudiant existe => le supprimer et retourner un flashMessage de succés
            $manager = $doctrine->getManager();
            // Ajoute la fonction de suppression dans la transaction
            $manager->remove($etudiant);
            // Exécuter la transacition
            $manager->flush();
            $this->addFlash('success', "La etudiant a été supprimé avec succès");
        } else {
            //Sinon  retourner un flashMessage d'erreur
            $this->addFlash('error', "etudiant innexistante");
        }
        return $this->redirectToRoute('etudiant.list');
    }
}
