<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Utilisateur;
use App\Form\DevisFormType;
use App\Form\RegistrationFormType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/app', name: 'app_app')]
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/services', name: 'services')]
    public function services(): Response
    {
        return $this->render('app/services.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/tarifs', name: 'tarifs')]
    public function tarifs(): Response
    {
        return $this->render('app/tarifs.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('app/contact.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
    #[Route('/mentions', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('app/mentions.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/politique', name: 'politique')]
    public function politique(): Response
    {
        return $this->render('app/politique.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('app/cgu.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    #[Route('/backoffice', name: 'backoffice')]
    public function backoffice(UtilisateurRepository $repo): Response
    {

        $utilisateurs = $repo->findAll();
        return $this->render('admin/backoffice.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/devis', name: 'devis')]
    public function devis(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devis = new Devis();
        $form = $this->createForm(DevisFormType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre demande de devis a bien été envoyée !');
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('app_accueil', [
                
            ]);
  
        }

        return $this->render('app/devis.html.twig', [
            'controller_name' => 'AppController',
            'devisForm' => $form->createView()
        ]);
    }

    #[Route('/admin/devis', name: 'admin_devis')]
    public function admin_devis(DevisRepository $repo): Response
    {
        $devis=$repo->findAll();
        return $this->render('admin/afficheDevis.html.twig', [
            'devis'=>$devis,
           
        ]);
    }
}
