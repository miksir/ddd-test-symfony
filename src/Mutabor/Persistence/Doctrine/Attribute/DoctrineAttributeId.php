<?php


namespace Mutabor\Persistence\Doctrine\Attribute;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Mutabor\Domain\Model\Room\RoomId;

class DoctrineAttributeId extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new RoomId($value);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'AttributeId';
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
