<?php

namespace ProductPromotionAlert\Form;

use Thelia\Form\BaseForm;

class CustomerSubscription extends BaseForm
{

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        // $this->formBuilder->add("");
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return "product_promotion_alert_customer_subscription";
    }
}