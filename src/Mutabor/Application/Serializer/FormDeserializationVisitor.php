<?php


namespace Mutabor\Application\Serializer;


use JMS\Serializer\GenericDeserializationVisitor;

class FormDeserializationVisitor extends GenericDeserializationVisitor
{

    protected function decode($str)
    {
        parse_str($str, $output);
        return $output;
    }
}