<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurtyController extends AbstractController
{
    /**
     * @Route("/inscription", name="securty_registration")
     */
    public function registration(Request $request, ManagerRegistry $managerRegistry)
    {     $user=new User();
        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()){
        $em = $managerRegistry->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('securty_login'); 
      }



    return $this->render('articles/registration.html.twig',[
        'form'=>$form->createView()]);
    }
    /**
     * @Route("/connexion", name="securty_login")
     */
   public function login() {

    return $this->render('articles/login.html.twig') ;
   }
}
