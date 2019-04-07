<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function show()
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy([
            'name' => 'Mykolas',
            'lastName' => 'Vitkus'
        ]);
        return $this->render('home/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit", name="edit_profile", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {

        $user = $this->getUser();
        if($this->getUser()==null)
        {
            return $this->redirectToRoute('app_login');
        }
        $currentPicture = $user->getPicture();
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();


            $file = $form->get('picture')->getData();
            if ($file instanceof UploadedFile) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('uploaded_pictures'),
                    $fileName
                );
                $data->setPicture($fileName);
                $em->persist($data);
            } else {
                $data->setPicture($currentPicture);
            }
            $em->flush();
            $this->addFlash(
                'success',
                'Profile successfully edited'
            );
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
