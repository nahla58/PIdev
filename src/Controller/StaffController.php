<?php

namespace App\Controller;

use App\Entity\Staff;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\PhoneNumber;

#[Route('/staff')]
class StaffController extends AbstractController
{
    #[Route('/', name: 'app_staff_index', methods: ['GET'])]
    public function index(StaffRepository $staffRepository): Response
    {
        return $this->render('staff/index.html.twig', [
            'staff' => $staffRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_staff_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($staff);
            $entityManager->flush();

            return $this->redirectToRoute('app_staff_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('staff/new.html.twig', [
            'staff' => $staff,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_staff_show', methods: ['GET'])]
    public function show(Staff $staff): Response
    {
        return $this->render('staff/show.html.twig', [
            'staff' => $staff,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_staff_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Staff $staff, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_staff_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('staff/edit.html.twig', [
            'staff' => $staff,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_staff_delete', methods: ['POST'])]
    public function delete(Request $request, Staff $staff, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staff->getId(), $request->request->get('_token'))) {
            $entityManager->remove($staff);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_staff_index', [], Response::HTTP_SEE_OTHER);
    }
   

    /**
     * @Route("/send-notification", name="send_notification")
     */
    public function sendSmsNotification(\Symfony\Component\Notifier\NotifierInterface $notifier)
    {
        // Créez la notification
        $notification = new Notification('Nouveau message du staff', ['twilio']);
    
        // Ajoutez les destinataires (numéro de téléphone du staff)
        $recipient = new PhoneNumber('94478684');
        $notification->addRecipient($recipient);
    
        // Envoyez la notification
        $notifier->send($notification);
    }
}

