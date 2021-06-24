<?php

namespace App\Controller;

use App\Entity\Reclamacion;
use App\Form\ReclamacionType;
use App\Repository\ReclamacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamacion")
 */
class ReclamacionController extends AbstractController
{
    /**
     * @Route("/", name="reclamacion_index", methods={"GET"})
     */
    public function index(ReclamacionRepository $reclamacionRepository): Response
    {
        return $this->render('reclamacion/index.html.twig', [
            'reclamacions' => $reclamacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reclamacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamacion = new Reclamacion();
        $form = $this->createForm(ReclamacionType::class, $reclamacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamacion);
            $entityManager->flush();

            return $this->redirectToRoute('reclamacion_index');
        }

        return $this->render('reclamacion/new.html.twig', [
            'reclamacion' => $reclamacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamacion_show", methods={"GET"})
     */
    public function show(Reclamacion $reclamacion): Response
    {
        return $this->render('reclamacion/show.html.twig', [
            'reclamacion' => $reclamacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamacion $reclamacion): Response
    {
        $form = $this->createForm(ReclamacionType::class, $reclamacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamacion_index');
        }

        return $this->render('reclamacion/edit.html.twig', [
            'reclamacion' => $reclamacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamacion_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamacion $reclamacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamacion_index');
    }
}
