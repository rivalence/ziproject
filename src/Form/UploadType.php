<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('directory', Assert\TextType::class, [
                'label' => 'Nom du dossier',
                'label_attr' => [
                    'class' => 'label' 
                ],
                'attr' => [
                    'readonly' => true,
                    'class' => 'input-text'
                ]
            ])
            ->add('files', Assert\FileType::class, [
                'attr' => [
                    'webkitdirectory' => true,
                    'class' => 'button'
                ],
                'label' => 'Selectionner le dossier source',
                'label_attr' => [
                    'class' => 'label' 
                ]
            ])
            ->add('submit', Assert\SubmitType::class, [
                'label' => 'Renommer et compresser',
                'attr' => [
                    'class' => 'button'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data-class' => UploadData::class
        ]);
    }
}
