<?php

namespace HedgeComm\EmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubscriberType extends AbstractType
{
	protected $em;
	
	public function __construct($em)
	{
		$this->em = $em;
	}

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', 'text', array(
              'constraints' => array(new NotBlank(), new Email())
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HedgeComm\EmailBundle\Entity\Subscriber'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hedgecomm_emailbundle_subscriber';
    }
}
