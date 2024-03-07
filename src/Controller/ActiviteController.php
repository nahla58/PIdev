<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



#[Route('/activite')]
class ActiviteController extends AbstractController
{
    #[Route('/', name: 'app_activite_index', methods: ['GET'])]
    public function index(Request $request,ActiviteRepository $activiteRepository,PaginatorInterface $paginator): Response
    {   
        $activites=$activiteRepository->findAll();
        $activites =$paginator->paginate(
            $activites,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }

    #[Route('/new', name: 'app_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
       
        $activite = new activite();
        $form = $this->createForm(activiteType::class, $activite);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'.'.$image->guessExtension();
    
                try {
                    //deplacer le fichier vers un répertoire
                    $image->move(
                        $this->getParameter('image_directory'), // Chemin vers le répertoire de stockage des documents
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'erreur de téléchargement de fichier
                }
    
                // Stockez le nom du fichier dans l'entité 
                $activite->setImage($newFilename);
            }
    
            $entityManager->persist($activite); // Enregistre l'objet $mecanicien dans le gestionnaire d'entités
            $entityManager->flush(); //Exécute réellement l'opération de persistance en base de données. 

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
    }
        
    
    #[Route('/front', name: 'app_activite_front')]
    public function front(): Response
    {
        $activites = $this->getDoctrine()->getRepository(Activite::class)->findAll();
        return $this->render('activite/front.html.twig', [
            'activites' => $activites, 
        ]);
    }
   
   
}
    





   


