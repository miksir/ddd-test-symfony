<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\Adapter\ArrayCollection;
use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;
use Mutabor\Domain\Model\DesignStyle\DesignStyle;
use Mutabor\Domain\Model\Room\Room;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoCollection;

class DesignInterior
{
    /**
     * @var DesignInteriorId
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var DesignProject
     */
    private $project;
    /**
     * @var Room
     */
    private $room;
    /**
     * @var DesignStyle
     */
    private $design_style;
    /**
     * @var DesignPhotoCollection|DesignPhoto[]
     */
    private $photo;

    private function __construct()
    {
        $this->photo = new DesignPhotoCollection();
    }

    /**
     * @param DesignInteriorId $id
     * @param string $title
     * @param string $description
     * @param DesignProject $project
     * @param Room $room
     * @param DesignStyle $designStyle
     * @param DesignPhotoCollection|DesignPhoto[] $photosCollection
     * @return DesignInterior
     */
    public static function create(
        DesignInteriorId $id,
        string $title,
        string $description,
        DesignProject $project,
        Room $room,
        DesignStyle $designStyle,
        DesignPhotoCollection $photosCollection
    ) {
        $self = new self;
        $self->id = $id;
        $self->title = $title;
        $self->description = $description;
        $self->project = $project;
        $self->room = $room;
        $self->design_style = $designStyle;
        $self->photo = $photosCollection;
        return $self;
    }

    public function update(
        string $title,
        string $description,
        Room $room,
        DesignStyle $designStyle,
        DesignPhotoCollection $photosCollection
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->room = $room;
        $this->design_style = $designStyle;
        $this->photo = $photosCollection;
    }

    /**
     * @return DesignInteriorId
     */
    public function getId() : DesignInteriorId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle() : string 
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @return Room
     */
    public function getRoom() : Room
    {
        return $this->room;
    }

    /**
     * @return DesignStyle
     */
    public function getDesignStyle() : DesignStyle
    {
        return $this->design_style;
    }

    /**
     * @return DesignPhotoCollection|DesignPhoto[]
     */
    public function getDesignPhotos()
    {
        return $this->photo;
    }
}