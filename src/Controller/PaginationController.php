<?php
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PaginationController extends AbstractController
{
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Activite::class)->createQueryBuilder('a')->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('activite/front.html.twig', [
            'pagination' => $pagination, // Assurez-vous de passer 'activites' au lieu de 'pagination'
        ]);
    }
}
