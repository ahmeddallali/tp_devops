<?php

namespace App\Controller;

use App\Entity\Utilisations;
use App\Form\Utilisations1Type;
use App\Repository\UtilisationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/utilisations")
 */
class UtilisationsController extends AbstractController
{
    /**
     * @Route("/", name="utilisations_index", methods={"GET"})
     */
    public function index(UtilisationsRepository $utilisationsRepository): Response
    {
        return $this->render('utilisations/index.html.twig', [
            'utilisations' => $utilisationsRepository->findAll(),
        ]);
    }


    /**
     * @Route("/listu", name="utilisateur_list", methods={"GET"})
     */
    public function listu(UtilisationsRepository $utilisationsRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $inter=$utilisationsRepository->findAll();
        //l'image est située au niveau du dossier public
        $png = file_get_contents("logocmr.jpg");
        $pngbase64 = base64_encode($png);



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('utilisations/listutil.html.twig', [
            'utilisateurs' => $inter ,
            "img64"=>$pngbase64
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Historiques d'utilisations.pdf", [
            "Attachment" => true
        ]);
    }





    /**
     * @Route("/new", name="utilisations_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisation = new Utilisations();
        $form = $this->createForm(Utilisations1Type::class, $utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisation);
            $entityManager->flush();

            return $this->redirectToRoute('utilisations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisations/new.html.twig', [
            'utilisation' => $utilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisations_show", methods={"GET"})
     */
    public function show(Utilisations $utilisation): Response
    {
        return $this->render('utilisations/show.html.twig', [
            'utilisation' => $utilisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisations_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Utilisations $utilisation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Utilisations1Type::class, $utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('utilisations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisations/edit.html.twig', [
            'utilisation' => $utilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisations_delete", methods={"POST"})
     */
    public function delete(Request $request, Utilisations $utilisation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('utilisations_index', [], Response::HTTP_SEE_OTHER);
    }
}
