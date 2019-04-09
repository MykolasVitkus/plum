<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Entity\User;
use App\Event\ContactSentEvent;
use App\Event\ContactSentSubscriber;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact/{id}", name="contact")
     */
    public function contactUser(Request $request, $id, EventDispatcherInterface $dispatcher)
    {
        $contactMessage = new ContactMessage();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(ContactType::class, $contactMessage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $contactMessage = $form->getData();
            $contactMessage->setUser($user);
            $em->getConnection()->beginTransaction();

            $em->persist($contactMessage);
            $em->flush();

            $event = new ContactSentEvent($contactMessage);
            $dispatcher->dispatch(ContactSentEvent::NAME, $event);

            $em->commit();
        }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView(),
            'user' => $user
        ]);
    }
}
