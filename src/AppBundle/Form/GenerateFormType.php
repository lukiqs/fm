<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GenerateFormType extends AbstractType{
    
    public function getName() {
        return "generate_form";
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('numberOfCodes','integer', array('label' => 'Number of codes'))
                ->add('numberOfChars','integer', array('label' => 'Number of chars'))
                ->add('save','submit');
    }

}
