<?php

namespace App\Controller;
use App\Entity\UserMessage;
use App\Form\UserMessageType;

use ReCaptcha\ReCaptcha;

use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;

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
    public function contact(Request $request, Recaptcha3Validator $recaptcha3Validator): Response
    {

        $secret = "6Le6yv4ZAAAAAFIvCbbCBPdeRfk5DLIYnDrpuQo0";
        $recaptchaGoogle = new ReCaptcha($secret);

        $userMess = new UserMessage();
        
        $form = $this->createForm(UserMessageType::class, $userMess);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $score = $recaptcha3Validator->getLastResponse()->getScore();

            if ($score <= 0.3) {
                $this->addFlash("error","Désolé problème");
                return $this->render('contact/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            } else {

                $this->addFlash("success","OK c'est fait");

                $task = $form->getData();

                $task->setDateTime(new \DateTime('now'));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($task);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }


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
