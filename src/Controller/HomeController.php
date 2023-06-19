<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $httpClient): Response
    {
        $reponse=$httpClient->request('GET','https://kaamelott.chaudie.re/api/random');
        return $this->render('home/index.html.twig', [
            'citation' => $reponse->toArray()['citation'],
        ]);
    }
}
