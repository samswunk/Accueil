<?php

namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateToStringTransformer implements DataTransformerInterface
{
    public function transform($dateObj)
    {
        $dateObj = $dateObj->getConvocations();
        if (null === $dateObj->getDateconvocation()) {
            return "";
        }
        
        // dd($dateObj->getDateconvocation()->format('d/m/Y H:i'));
        return $dateObj->getDateconvocation()->format('d/m/Y H:i');
    }

    public function reverseTransform($date)
    {
        if ($date === "") {
            return null;
        }
        $dateObj = new \DateTime($date);

        return $dateObj;
    }
}