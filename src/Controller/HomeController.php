<?php

namespace App\Controller;

use App\Entity\User;
use App\Forms\EditUserType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function show()
    {
        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user,
        ]);
    }
    /**
     * @Route("/edit", name="edit_profile", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $currentPicture = $user->getPicture();
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();


            $file = $form->get('Picture')->getData();
            if($file instanceof UploadedFile) {
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('uploaded_pictures'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $e = 'There was an error while uploading your image';
                }
                $data->setPicture($fileName);
                $em->persist($data);
            }
            else {
                $data->setPicture($currentPicture);
            }
            $em->flush();
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
