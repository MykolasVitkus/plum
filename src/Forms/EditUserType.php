<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 4/5/2019
 * Time: 10:41
 */

namespace App\Forms;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;


class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('birthDate', BirthdayType::class)
            ->add('email')
            ->add('phoneNumber')
            ->add('experience')
            ->add('aboutMe')
            ->add('picture', FileType::class, array(
                    'data_class' => null,
                    'required' => false,
            ))
            ->add('submit', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}