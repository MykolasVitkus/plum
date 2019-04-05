<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\EditUserForm;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll()[0];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user,
        ]);
    }
    /**
     * @Route("/edit", name="edit_profile", methods={"GET","POST"},)
     */
    public function edit(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(EditUserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $user->getPicture();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('uploaded_pictures'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $user->setPicture($fileName);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('edit_profile/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }


}
