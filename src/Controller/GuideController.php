<?php
namespace App\Controller;
use App\Entity\Resto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

}

