<?php

namespace App\Controller;

use App\Entity\Echouage;
use App\Entity\Espece;
use App\Entity\Zone;
use App\Form\EchouageType;
use App\Form\AccueilType; 
use PhpParser\Node\Stmt\Echo_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/echouage")
 */
class EchouageController extends AbstractController
{
    /**
     * @Route("/accueil", name="echouage_accueil", methods={"GET","POST"})
     */
    public function accueil(Request $request): Response
    {
        /*  $zones = $this->getDoctrine()
            ->getRepository(Zone::class)
            ->findAll();

        $especes = $this->getDoctrine()
            ->getRepository(Espece::class)
            ->findAll();
        */
        $salle = new Echouage();
        $form = $this->createForm(AccueilType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $espece_id = $form['espece']->getData()->getId();
            $zone_id = $form['zone']->getData()->getId();
            return $this->redirect($this->generateUrl('echouage_search', array(
                'espece' => $espece_id, 'zone' => $zone_id
            )));
        }

        return $this->render('echouage/accueil.html.twig', [
            /*    'zones' => $zones,
            'especes' => $especes,*/
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="echouage_search", methods={"GET"})
     */
    public function search(Request $requete): Response
    {
        $espece_id = $requete->query->get("espece");
        $zone_id = $requete->query->get("zone");

        $espece_name = $this->getDoctrine()->getRepository(Espece::class)->getEspeceName($espece_id);

        $echouages = $this->getDoctrine()->getRepository(Echouage::class)->getEchouages($zone_id, $espece_id);

        //Je créé un tableau qui contient toutes les dates une seule fois
        $dates_array = [];
        foreach ($echouages as $echouage) {
            array_push($dates_array, $echouage['date']);
        }


        $output = [];

        if (!$zone_id) { //Si toutes les zones sélectionnées
            $zone_names = $this->getDoctrine()->getRepository(Zone::class)->findAll();


            foreach ($zone_names as $zone) {
                $dateNumberArray = [];
                $echouagesByZone = $this->getDoctrine()->getRepository(Echouage::class)->getEchouages($zone['id'], $espece_id);
                foreach ($dates_array as $date) {
                    $date_count = 0;
                    foreach ($echouagesByZone as $echouageByZone) {
                        if ($echouageByZone['date'] == $date) $date_count++; //Si l'echouage a eu lieu à cette date
                    }
                    $dateNumberArray[$date] = $date_count; //Contient 'date'=>'nombreEchouagesACetteDate'
                }
                $output[$zone['id']] = $dateNumberArray;
            }
        } else { //Si une seule zone est sélectionnée
            $dateNumberArray = [];
            foreach ($dates_array as $date) {
                $date_count = 0;
                foreach ($echouages as $echouage) {
                    if ($echouage['date'] == $date) $date_count++; //Si l'echouage a eu lieu à cette date
                }
                $dateNumberArray[$date] = $date_count; //Contient 'date'=>'nombreEchouagesACetteDate'
            }
            $zone_names = $this->getDoctrine()->getRepository(Zone::class)->findById($zone_id);
            $output[$zone_names[0]['id']] = $dateNumberArray;
        }

        return $this->render('echouage/search.html.twig', [
            'echouages' => $output,
            'zones' => $zone_names,
            'espece' => $espece_name['espece'],
        ]);
    }

    /**
     * @Route("/", name="echouage_index", methods={"GET"})
     */
    public function index(): Response
    {
        $echouages = $this->getDoctrine()
            ->getRepository(Echouage::class)
            ->findAll();

        return $this->render('echouage/index.html.twig', [
            'echouages' => $echouages,
        ]);
    }

    /**
     * @Route("/new", name="echouage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $echouage = new Echouage();
        $form = $this->createForm(EchouageType::class, $echouage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($echouage);
            $entityManager->flush();

            return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('echouage/new.html.twig', [
            'echouage' => $echouage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="echouage_show", methods={"GET"})
     */
    public function show(Echouage $echouage): Response
    {
        return $this->render('echouage/show.html.twig', [
            'echouage' => $echouage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="echouage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Echouage $echouage): Response
    {
        $form = $this->createForm(EchouageType::class, $echouage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('echouage/edit.html.twig', [
            'echouage' => $echouage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="echouage_delete", methods={"POST"})
     */
    public function delete(Request $request, Echouage $echouage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $echouage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($echouage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('echouage_index', [], Response::HTTP_SEE_OTHER);
    }
}
