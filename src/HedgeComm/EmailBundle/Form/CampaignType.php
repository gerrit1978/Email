<?php

namespace HedgeComm\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromName')
            ->add('fromEmail')
            ->add('replyTo')
            ->add('textPlain')
            ->add('textHtml')
            ->add('sent')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HedgeComm\EmailBundle\Entity\Campaign'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hedgecomm_emailbundle_campaign';
    }
}
