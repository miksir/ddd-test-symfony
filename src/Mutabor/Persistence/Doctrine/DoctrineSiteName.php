<?php


namespace Mutabor\Persistence\Doctrine;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use Mutabor\Domain\VO\SiteName;
use Mutabor\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineSiteName extends Type
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return SiteName::class;
    }

    /**
     * Property inside VO to set value
     * @return string
     */
    protected function getVOPropertyName()
    {
        return 'site_name';
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration['length'] = $this->getDefaultLength($platform);
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }
    
    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 128;
    }
}