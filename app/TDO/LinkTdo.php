<?php


namespace App\TDO;


class LinkTdo
{
    private int $fileId;
    private string $singleView;

    /**
     * LinkTdo constructor.
     * Insert data
     *
     * @param int $fileId
     * @param string|null $singleView
     */
    public function __construct(
        int $fileId,
        string $singleView = null
    )
    {
        $this->fileId = $fileId;
        $this->singleView = $singleView ? $singleView : '';
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function getSingleView(): string
    {
        return $this->singleView;
    }
}
