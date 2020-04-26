<?php


namespace App\TDO;


class FileTdo
{
    private string $fileName;
    private string $comment;
    private string $dateRemove;
    private object $file;

    /**
     * FileTdo constructor.
     * Insert data
     * @param $fileName
     * @param $comment
     * @param $dateRemove
     */
    public function __construct(
        string $fileName,
        string $comment,
        string $dateRemove,
        object $file
    )
    {
        $this->fileName = $fileName;
        $this->comment = $comment;
        $this->dateRemove = $dateRemove;
        $this->file = $file;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getDateRemove(): string
    {
        return $this->dateRemove;
    }

    public function getFile(): object
    {
        return $this->file;
    }
}
