<?php

namespace App\Form\Type;

use App\Entity\ContactMessage;
//use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
//use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactMessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Your Name',
                    ],
                ]
            )
            ->add(
                'mobileNumber',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Your Phone',
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Your Email',
                    ],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'rows' => 5,
                        'placeholder' => 'Your Message',
                    ],
                ]
            )
//            ->add(
//                'recaptcha',
//                EWZRecaptchaV3Type::class, // TODO
//                [
//                    'action_name' => 'contact',
//                    'mapped' => false,
//                    'constraints' => [
//                        new IsTrueV3(),
//                    ],
//                ]
//            )
            ->add(
                'send',
                SubmitType::class,
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
