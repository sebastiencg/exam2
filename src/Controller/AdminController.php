<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Entity\User;
use App\Repository\QuoteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),

        ]);
    }
    #[Route('/quote', name: 'app_admin_quote', methods: ['GET'])]
    public function quote(QuoteRepository $quoteRepository): Response
    {
        return $this->render('admin/admin-quote.html.twig', [
            'quotes' => $quoteRepository->findAll(),
        ]);
    }
    #[Route('/promote/{id}', name: 'app_user_promote', methods: ['GET'])]
    public function promote(Request $request, User $user, UserRepository $userRepository): Response
    {
        if($user->getRoles()==["ROLE_USER"]){

            $user->setRoles(["ROLE_ADMIN"]);
        }
        else{
            $user->setRoles([]);
        }

        $userRepository->save($user, true);
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'app_admin_remove', methods: ['GET'])]
    public function remove(Quote $quote ,QuoteRepository $quoteRepository): Response
    {
        $quoteRepository->remove($quote, true);

        return $this->redirectToRoute('app_admin_quote');
    }
}
