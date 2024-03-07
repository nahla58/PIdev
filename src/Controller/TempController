<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TempController extends AbstractController
{
    #[Route('/back', name: 'app_tempback')]
    public function back(): Response
    {
        return $this->render('basedb.html.twig', [
            'controller_name' => 'TempController',
        ]);
    }
}
