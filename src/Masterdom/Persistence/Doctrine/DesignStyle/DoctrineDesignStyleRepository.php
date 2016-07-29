<?php


namespace Masterdom\Persistence\Doctrine\DesignStyle;


use Masterdom\Domain\Model\DesignStyle\DesignStyle;
use Masterdom\Domain\Model\DesignStyle\DesignStyleDoesNotExistException;
use Masterdom\Domain\Model\DesignStyle\DesignStyleId;
use Masterdom\Domain\Model\DesignStyle\DesignStyleRepository;
use Masterdom\Domain\VO\SiteName;
use Masterdom\Persistence\Doctrine\DoctrineEntityRepository;

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