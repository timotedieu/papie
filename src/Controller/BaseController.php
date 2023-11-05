<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VeloType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends AbstractController
{
    #[Route('/base', name: 'app_base')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [

        ]);
    }

        #[Route('/ajoutVelot', name: 'app_ajoutVelot')]
    public function ajoutVelot(Request $request, EntityManagerInterface $em): Response
    {
        $ajoutVelot = new Velo();
        $form = $this->createForm(VeloType::class, $ajoutVelot);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($ajoutVelot);
                $em->flush();
                $this->addFlash('notice','Message envoyé');
                return $this->redirectToRoute('app_ajoutVelot');
            }
            }
        
        return $this->render('base/ajoutVelot.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
