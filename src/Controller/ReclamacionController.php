<?php

namespace App\Controller;

use App\Entity\Reclamacion;
use App\Form\ReclamacionType;
use App\Form\RespuestaType;
use App\Manager\ReclamacionesManager;
use App\Manager\UsuarioManager;
use App\Repository\ReclamacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/reclamacion")
 */
class ReclamacionController extends AbstractController
{

    /** @var ReclamacionesManager $reclamacionesManager */
    private $reclamacionesManager;



    public function __construct( ReclamacionesManager  $reclamacionesManager)
    {
        $this->reclamacionesManager = $reclamacionesManager;
    }
    /**
     * @Route("/", name="reclamacion_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('reclamacion/index.html.twig', [
            'reclamacions' => $this->reclamacionesManager->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="reclamacion_show", methods={"GET"})
     */
    public function showAction(Reclamacion $reclamacion): Response
    {
        return $this->render('reclamacion/show.html.twig', [
            'reclamo' => $reclamacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamacion_edit", methods={"GET","POST"})
     */
    public function editAction(Request $request, Reclamacion $reclamacion): Response
    {
        $form = $this->createForm(ReclamacionType::class, $reclamacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reclamacionesManager->updateReclamacion($reclamacion);

            return $this->redirectToRoute('reclamacion_show',array('id'=>$reclamacion->getId()));
        }

        return $this->render('reclamacion/edit.html.twig', [
            'reclamacion' => $reclamacion,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/responder", name="reclamacion_responder", methods={"GET","POST"})
     */
    public function responderAction(Request $request, Reclamacion $reclamacion): Response
    {
        $form = $this->createForm(RespuestaType::class, $reclamacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reclamacionesManager->addRepuesta($reclamacion);

            return $this->redirectToRoute('reclamacion_show',array('id'=>$reclamacion->getId()));
        }

        return $this->render('reclamacion/respuesta.html.twig', [
            'reclamo' => $reclamacion,
            'form' => $form->createView(),
        ]);
    }

}
