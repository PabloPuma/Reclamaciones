<?php

namespace App\Form;

use App\Entity\Reclamacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReclamacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres',TextType::class)
            ->add('apellido_paterno',TextType::class)
            ->add('apellido_materno',TextType::class)
            ->add('celular',TelType::class)
            ->add('email',EmailType::class)
            ->add('tipo_documento', ChoiceType::class, array(
                'label'    => "Tipo de Documento",
                'choices'  => array('DNI' => 1, 'CE' => 0,'RUC'=>6,'PASAPORTE'=>7),
                'required' => true,
            ))
            ->add('documento', TextType::class, array(
                'label'    => "Documento de identidad",
                'required' => true,
            ))
            ->add('bien_contratado', ChoiceType::class, array(
                'label'    => "Tipo",
                'choices'  => array( 'SERVICIO' => 'SERVICIO','PRODUCTO' => 'PRODUCTO'),
                'required' => true,
            ))
            ->add('descripcion',TextareaType::class)
            ->add('detalle_reclamo', ChoiceType::class, array(
                'label'    => "Tipo",
                'choices'  => array('RECLAMO' => 'RECLAMO', 'QUEJA' => 'QUEJA'),
                'required' => true,
            ))
            ->add('detalle',TextareaType::class,array(
                'label' => 'Detalle',
                'attr'      => array(
                    'cols' => '5',
                    'rows' => '5'
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamacion::class,
        ]);
    }
}
