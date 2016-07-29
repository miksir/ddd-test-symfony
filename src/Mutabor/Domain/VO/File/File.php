<?php


namespace Mutabor\Domain\VO\File;


class File
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $hash;
    /**
     * @var int
     */
    protected $size;
    /**
     * @var string
     */
    protected $mime;

    protected function __construct()
    {
    }

    /**
     * @param string $path
     * @param string $name
     * @return static
     * @throws FileNotExistsException
     */
    public static function fromDisk(string $path, string $name)
    {
        $self = new static();
        $self->name = $name;
        $self->path = $path;
        
        $self->checkFileExists();

        $self->hash = $self->calculateHash();
        $self->size = $self->fileSize();
        $self->mime = $self->detectFiletype();

        $self->checkFileFormat();
        
        return $self;
    }
    
    /**
     * @param string $algo
     * @return string
     * @throws FileNotExistsException
     */
    protected function calculateHash($algo = 'md5')
    {
        $fp = fopen($this->path, 'r');
        if (!$fp) {
            return null;
        }
        $ctx = hash_init($algo);
        hash_update_stream($ctx, $fp);
        return hash_final($ctx);
    }

    protected function fileSize()
    {
        $stat = stat($this->path);
        return $stat ? $stat['size'] : 0;
    }

    protected function detectFiletype()
    {
        $fh = new \finfo(FILEINFO_MIME);
        $mime = $fh->file($this->path);
        if (($pos = strpos($mime, ';')) !== false) {
            $mime = substr($mime, 0, $pos);
        }
        return $mime;
    }

    /**
     * @throws FileNotExistsException
     */
    protected function checkFileExists()
    {
        if (!file_exists($this->path)) {
            throw new FileNotExistsException();
        }
    }
    
    protected function checkFileFormat()
    {
        
    }
    
    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Filename or URI
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }
}