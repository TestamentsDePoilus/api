<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppPreferenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectTitle',               TextType::class,        array("required" => true))
            ->add('helpHomeContent',            TextType::class,        array("required" => false))
            ->add('helpInsideHomeContent',      TextType::class,        array("required" => false))
            ->add('discoverHomeContent',        TextType::class,        array("required" => false))
            ->add('aboutContent',               TextType::class,        array("required" => false))
            ->add('legalNoticesContent',        TextType::class,        array("required" => false))
            ->add('creditsContent',             TextType::class,        array("required" => false))
            ->add('facebookPageId',             TextType::class,        array("required" => false))
            ->add('twitterId',                  TextType::class,        array("required" => false))
            ->add('enableContact',              CheckboxType::class,    array("required" => false))
            ->add('systemEmail',                EmailType::class,       array("required" => true))
            ->add('contactEmail',               EmailType::class,       array("required" => true))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AppPreference',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_apppreference';
    }


}
