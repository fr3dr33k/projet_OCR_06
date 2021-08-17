<?php

namespace App\Form;

use App\Entity\UserMessage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom"
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom"
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr" => [
                    "type" => "email",
                    "placeholder" => "votre@email.fr"
                ]
            ])
            ->add('message' , TextareaType::class , [
                "label" => "Message"
            ])
            ->add('datetime', HiddenType::class)
            ->add('save', SubmitType::class, [
                "label" => "Envoyer"
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserMessage::class,
        ]);
    }
}
