<?php

namespace App\Form;

use App\Entity\Menus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        //ajout du champs images
        ->add('images',FileType::class,[
            "label"=> false,
            "multiple"=> true,
            "mapped"=> false,
            "required"=> false  
        ])

            ->add('nom' ,TextType::class,[
                "required"=>false,
                "constraints"=>[
                    new NotBlank([
                        "message"=>"Le Nom est Obligatoire."
                    ])
                    ]
            ])

            ->add('prix',TextType::class,[
                "required"=>false,
                "constraints"=>[
                    new NotBlank([
                        "message"=>"Le Prix est Obligatoire."
                    ])
                    ]
            ])

            ->add('detail',TextareaType::class,[
                "required"=>false,
                "constraints"=>[
                    new NotBlank([
                        "message"=>"Les details sont Obligatoires."
                    ])
                    ]
            ])
            // ->add('commandes')
            ->add('burgerss')
            ->remove('complements')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menus::class,
        ]);
    }
}
