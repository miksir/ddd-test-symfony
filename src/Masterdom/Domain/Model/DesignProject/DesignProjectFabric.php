<?php


namespace Masterdom\Domain\Model\DesignProject;


use Masterdom\Domain\Model\DesignStyle\DesignStyle;
use Masterdom\Domain\Model\Room\Room;
use Masterdom\Domain\Model\User\User;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoCollection;
use Masterdom\Domain\VO\SiteName;

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
     * @param \Masterdom\Domain\Model\DesignPhoto\DesignPhotoCollection $photosCollection
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