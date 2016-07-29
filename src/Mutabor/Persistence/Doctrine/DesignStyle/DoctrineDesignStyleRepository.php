<?php


namespace Mutabor\Persistence\Doctrine\DesignStyle;


use Mutabor\Domain\Model\DesignStyle\DesignStyle;
use Mutabor\Domain\Model\DesignStyle\DesignStyleDoesNotExistException;
use Mutabor\Domain\Model\DesignStyle\DesignStyleId;
use Mutabor\Domain\Model\DesignStyle\DesignStyleRepository;
use Mutabor\Domain\VO\SiteName;
use Mutabor\Persistence\Doctrine\DoctrineEntityRepository;

class DoctrineDesignStyleRepository extends DoctrineEntityRepository implements DesignStyleRepository
{

    public function relatedEntity() : string
    {
        return DesignStyle::class;
    }

    /**
     * @param DesignStyleId $id
     * @return DesignStyle
     * @throws DesignStyleDoesNotExistException
     */
    public function byId(DesignStyleId $id) : DesignStyle
    {
        $style = $this->find($id);
        if (is_null($style)) {
            throw new DesignStyleDoesNotExistException();
        }
        return $style;
    }

    /**
     * @param SiteName $siteName
     * @return DesignStyle
     * @throws DesignStyleDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : DesignStyle
    {
        $style = $this->findOneBy(['site_name' => (string)$siteName]);
        if (is_null($style)) {
            throw new DesignStyleDoesNotExistException();
        }
        return $style;
    }

    /**
     * @return DesignStyle[]
     */
    public function all() : array
    {
        return $this->findAll();
    }
}