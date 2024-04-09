<?php

namespace App\Controller;

use App\Entity\Interventions;
use App\Form\InterventionsType;
use App\Repository\InterventionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/interventions")
 */
class InterventionsController extends AbstractController
{
    /**
     * @Route("/admin/utilisateur/search", name="utilsearch1")
     */
    public function searchPlanajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Interventions::class);
        $requestString = $request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        return $this->render('interventions/utilajax.html.twig', [
            'interventions' => $plan,
        ]);
    }

     /**
     * @Route("/listi", name="intervention_list", methods={"GET"})
     */
    public function listi(InterventionsRepository $interventionsRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $inter=$interventionsRepository->findAll();
        //l'image est située au niveau du dossier public
        $png = file_get_contents("logocmr.jpg");
        $pngbase64 = base64_encode($png);



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('interventions/listinter.html.twig', [
            'interventions' => $inter ,
            "img64"=>$pngbase64
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Historiques des interventions.pdf", [
            "Attachment" => true
        ]);
    }


    




    /**
     * @Route("/", name="interventions_index", methods={"GET"})
     */
    public function index(InterventionsRepository $interventionsRepository): Response
    {
        return $this->render('interventions/index.html.twig', [
            'interventions' => $interventionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="interventions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intervention = new Interventions();
        $form = $this->createForm(InterventionsType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('interventions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interventions/new.html.twig', [
            'intervention' => $intervention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="interventions_show", methods={"GET"})
     */
    public function show(Interventions $intervention): Response
    {
        return $this->render('interventions/show.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="interventions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Interventions $intervention, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InterventionsType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('interventions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('interventions/edit.html.twig', [
            'intervention' => $intervention,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="interventions_delete", methods={"POST"})
     */
    public function delete(Request $request, Interventions $intervention, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
            $entityManager->remove($intervention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('interventions_index', [], Response::HTTP_SEE_OTHER);
    }
}
