<?php

namespace App\Controller;
use App\Entity\UserMessage;
use App\Form\UserMessageType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }


    /**
     * @Route("/services", name="services")
     */
    public function services(): Response
    {
        return $this->render('services/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request): Response
    {


        $userMess = new UserMessage();
        
        $form = $this->createForm(UserMessageType::class, $userMess);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            
            $task = $form->getData();
            
            $task->setDateTime(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tarifs", name="tarifs")
     */
    public function tarifs(): Response
    {
        return $this->render('tarifs/index.html.twig');
    }
}
