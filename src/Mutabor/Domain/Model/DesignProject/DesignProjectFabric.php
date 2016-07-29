<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\Model\DesignStyle\DesignStyle;
use Mutabor\Domain\Model\Room\Room;
use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoCollection;
use Mutabor\Domain\VO\SiteName;

class DesignProjectFabric
{
    /**
     * @param DesignProjectId $id
     * @param User $owner
     * @param string $name
     * @param string $description
     * @param SiteName $siteName
     * @return DesignProject
     */
    public function create(
        DesignProjectId $id,
        User $owner,
        string $name,
        string $description,
        SiteName $siteName
    )
    {
        return DesignProject::create($id, $owner, $name, $description, $siteName);
    }

    /**
     * @param DesignInteriorId $id
     * @param string $title
     * @param string $description
     * @param DesignProject $project
     * @param Room $room
     * @param DesignStyle $designStyle
     * @param \Mutabor\Domain\Model\DesignPhoto\DesignPhotoCollection $photosCollection
     * @return DesignInterior
     */
    public function createInterior(
        DesignInteriorId $id,
        string $title,
        string $description,
        DesignProject $project,
        Room $room,
        DesignStyle $designStyle,
        DesignPhotoCollection $photosCollection
    )
    {
        return DesignInterior::create($id, $title, $description, $project, $room, $designStyle, $photosCollection);
    }
}