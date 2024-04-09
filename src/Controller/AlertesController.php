<?php

namespace App\Controller;

use App\Entity\Alertes;
use App\Form\Alertes1Type;
use App\Repository\AlertesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/alertes")
 */
class AlertesController extends AbstractController
{
    /**
     * @Route("/", name="alertes_index", methods={"GET"})
     */
    public function index(AlertesRepository $alertesRepository): Response
    {
        return $this->render('alertes/index.html.twig', [
            'alertes' => $alertesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alertes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $alerte = new Alertes();
        $form = $this->createForm(Alertes1Type::class, $alerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($alerte);
            $entityManager->flush();

            return $this->redirectToRoute('alertes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alertes/new.html.twig', [
            'alerte' => $alerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alertes_show", methods={"GET"})
     */
    public function show(Alertes $alerte): Response
    {
        return $this->render('alertes/show.html.twig', [
            'alerte' => $alerte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alertes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Alertes $alerte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Alertes1Type::class, $alerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('alertes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alertes/edit.html.twig', [
            'alerte' => $alerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alertes_delete", methods={"POST"})
     */
    public function delete(Request $request, Alertes $alerte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alerte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($alerte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alertes_index', [], Response::HTTP_SEE_OTHER);
    }
}
