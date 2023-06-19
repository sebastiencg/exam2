<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    #[Route('/quote/new', name: 'app_quote_new')]
    public function index(Request $request, QuoteRepository $quoteRepository): Response
    {
        $quote = new Quote();
        $quote->setSentence($request->get('sentence'));
        $quote->setPersonnage($request->get('personnage'));
        $quote->addOfUser($this->getUser());
        if ($quoteRepository->findBy(["sentence"=>$request->get('sentence')])){
            return $this->redirectToRoute('app_register', [], Response::HTTP_SEE_OTHER);
        }
        $quoteRepository->save($quote,true);
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/quote/myQuote', name: 'app_my_quote')]
    public function myList(): Response
    {
        $quotes=$this->getUser()->getQuotes();
        return $this->render('quote/index.html.twig',[
            'quotes'=>$quotes
        ]);
    }
    #[Route('/quote/best', name: 'app_best')]
    public function best(QuoteRepository $quoteRepository): Response
    {
        /*$quotes=$quoteRepository->findAll();
        foreach ($quotes as $quote){
            $numberUser=count($quote->getOfUser());
            array_push($table,$numberUser);
        }*/

        $quotes=$quoteRepository->findBy([],["id"=>"DESC"],3);
        return $this->render('quote/best.html.twig',[
            'quotes'=>$quotes
        ]);
    }
    #[Route('/quote/myQuote/remove/{id}', name: 'app_my_quote_remove')]
    public function remove(Quote $quote): Response{
        $quote->removeOfUser($this->getUser());
        $this->getUser()->removeQuote($quote);
        return $this->redirectToRoute('app_my_quote');
    }


}
