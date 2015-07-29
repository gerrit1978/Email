<?php

namespace HedgeComm\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
              'constraints' => array(new NotBlank())
            ))
            ->add('fromName', 'text', array(
              'constraints' => array(new NotBlank())
            ))
            ->add('fromEmail', 'text', array(
              'constraints' => array(new NotBlank())
            ))
            ->add('replyTo', 'text', array(
              'constraints' => array(new NotBlank())
            ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HedgeComm\EmailBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hedgecomm_emailbundle_client';
    }
}
