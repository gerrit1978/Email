<?php

namespace HedgeComm\EmailBundle\Form;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;


class SubscriberListType extends AbstractType
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
            ->add('name', NULL, array('constraints' => array(new NotBlank())))
            ->add('description')
            ->add('status', 'choice', array('choices' => array(0 => 'inactive',1 => 'active')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HedgeComm\EmailBundle\Entity\SubscriberList'
        ));
    }
    
    /**
	 *  @param 

    /**
     * @return string
     */
    public function getName()
    {
        return 'hedgecomm_emailbundle_subscriberlist';
    }
}
