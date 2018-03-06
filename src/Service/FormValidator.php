<?php

namespace App\Service;


use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

class FormValidator
{
    /**
     * @param FormInterface $form
     * @return array
     */
    public function getFormErrors(FormInterface $form): array
    {
        $errors = array();

        //this loop gets the main form errors (generic errors)
        /** @var FormError $mainFormError */
        foreach ($form->getErrors() as $mainFormError) {
            array_push($errors,$mainFormError->getMessage());
        }

        //this loop gets specific form components errors
        /** @var FormInterface $childForm */
        foreach ($form->all() as $childForm) {
            if($childForm instanceof FormInterface && $childErrors = $this->getFormErrors($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }

        return $errors;
    }
}