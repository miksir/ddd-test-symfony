<?php


namespace Mutabor\Application\Serializer;


use JMS\Serializer\GenericDeserializationVisitor;

class MultipartDeserializationVisitor extends GenericDeserializationVisitor
{

    protected function decode($str)
    {
        return [];
    }
}