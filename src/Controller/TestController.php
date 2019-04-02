<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 19.3.23
 * Time: 10.20
 */

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * @Route("/{reactRouting}", name="index", defaults={"reactRouting": null})
     */
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }
}