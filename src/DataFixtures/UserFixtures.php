<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 4/7/2019
 * Time: 18:08
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $om)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $user->setName('Mykolas');
        $user->setLastName('Vitkus');
        $user->setEmail('mykolasvitkus@gmail.com');
        $user->setBirthDate(date_create("1999-03-31"));
        $user->setPhoneNumber('+37069922083');
        $user->setExperience('HTML, SCSS, JavaScript, OOP(C#, Java), PHP(Symfony), Agile, Git, Jira');
        $user->setAboutMe('Still in development');

        $om->persist($user);
        $om->flush();
    }

}