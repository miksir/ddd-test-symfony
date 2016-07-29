<?php


namespace Mutabor\Domain\VO\File;


class Image extends File
{
    protected $width;
    protected $height;

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    protected function checkFileFormat()
    {
        if (!preg_match('/^image\//', $this->mime)) {
            throw new ImageWrongFiletypeException();
        }

        $image = getimagesize($this->path);
        if (!$image) {
            throw new ImageWrongFiletypeException();
        }

        $this->width = $image[0];
        $this->height = $image[1];
    }

}