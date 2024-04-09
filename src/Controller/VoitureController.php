<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\Voiture1Type;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/voiture")
 */
class VoitureController extends AbstractController
{
    /**
     * @Route("/admin/utilisateur/search", name="utilsearch")
     */
    public function searchPlanajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $requestString = $request->get('searchValue');
        $plan = $repository->findPlanBySujet($requestString);
        return $this->render('voiture/utilajax.html.twig', [
            'voitures' => $plan,
        ]);
    }




    /**
     * @Route("/", name="voiture_index", methods={"GET"})
     */
    public function index(VoitureRepository $voitureRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $allvoiture=$voitureRepository->findAll();
        $voitures = $paginator->paginate(
            // Doctrine Query, not results
            $allvoiture,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );



        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    /**
     * @Route("/listv", name="voiture_list", methods={"GET"})
     */
    public function listv(VoitureRepository $voitureRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $allvoiture=$voitureRepository->findAll();
        //l'image est située au niveau du dossier public
        $png = file_get_contents("logocmr.jpg");
        $pngbase64 = base64_encode($png);



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('voiture/listfvoiture.html.twig', [
            'voitures' => $allvoiture,
            "img64"=>$pngbase64
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("listes des voitures.pdf", [
            "Attachment" => true
        ]);
    }




    /**
     * @Route("/new", name="voiture_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(Voiture1Type::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            
            $file_name=md5(uniqid())    . '.'   . $file->guessExtension();
            try{
            $file->move(
                $this->getParameter('images_directory'),
                $file_name
            
            );
        }catch (FileException $e) {
            //ffff
        }
            $voiture->setImage($file_name);
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        
        }
        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_show", methods={"GET"})
     */
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voiture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Voiture1Type::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_delete", methods={"POST"})
     */
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}
