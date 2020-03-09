<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuideController extends AbstractController{
    public function accueil() {
        $nombre = rand(1, 84);
        return $this->render('guide/accueil.html.twig', array('numero' => $nombre));
    }

}

