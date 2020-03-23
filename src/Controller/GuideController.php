<?php
namespace App\Controller;
use App\Entity\Resto;
use App\Form\Type\RestoType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class GuideController extends AbstractController{
    public function accueil() {
        $nombre = rand(1, 84);
        return $this->render('guide/accueil.html.twig', array('numero' => $nombre));
    }

    public function menu() {
        return $this->render('guide/menu.html.twig');
    }

    public function voir($id) {
        $resto = $this->getDoctrine()->getRepository(Resto::class)->find($id);
        if(!$resto)
            throw $this->createNotFoundException('Resto[id='.$id.'] inexistante');
        return $this->render('guide/voir.html.twig',
            array('resto' => $resto));
    }

    public function restos() {
        $restos = $this->getDoctrine()->getRepository(Resto::class)->findAll();
        return $this->render('guide/restos.html.twig',
            array('restos' => $restos));
    }

    public function ajouter($nom, $chef, $etoile) {
        $entityManager = $this->getDoctrine()->getManager();
        $resto = new Resto;
        $resto->setNom($nom);
        $resto->setChef($chef);
        $resto->setEtoile($etoile);
        $entityManager->persist($resto);
        $entityManager->flush();
        return $this->redirectToRoute('guide_michelin_voir',
            array('id' => $resto->getId()));
    }

    public function ajouter2(Request $request) {
        $resto = new Resto;
        $form = $this->createForm(RestoType::class, $resto, ['action' => $this->generateUrl('guide_michelin_ajouter2')]);
        $form->add('submit', SubmitType::class, array('label' => 'Sauver'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resto);
            $entityManager->flush();
            return $this->redirectToRoute('guide_michelin_voir',
                array('id' => $resto->getId()));
        }
        return $this->render('guide/ajouter.html.twig',
            array('monFormulaire' => $form->createView()));
    }

    public function edit($id, Request $request) {
        $resto = $this->getDoctrine()->getRepository(Resto::class)->find($id);
        $form = $this->createForm(RestoType::class, $resto, ['action' => $this->generateUrl('guide_michelin_ajouter2')]);
        $form->add('submit', SubmitType::class, array('label' => 'Sauver'));
        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resto);
            $entityManager->flush();
            return $this->redirectToRoute('guide_michelin_voir',
                array('id' => $resto->getId()));
        }
        return $this->render('guide/ajouter.html.twig',
            array('monFormulaire' => $form->createView()));
    }


}

