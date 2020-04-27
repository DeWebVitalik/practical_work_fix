<?php


namespace App\Services;


use App\File;
use App\Link;

class StatisticsService
{
    protected int $userId;

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getStatistic(): array
    {
        return [
            'totalViews' => $this->getTotalViews(),
            'totalFiles' => $this->getTotalFiles(),
            'totalDeletedFiles' => $this->getTotalDeletedFiles(),
            'totalOneTimeLinks' => $this->getTotalOneTimeLinks(),
            'totalUsedOneTimeLinks' => $this->getTotalUsedOneTimeLinks()
        ];
    }

    /**
     * @return int
     * @throws \Exception
     */
    protected function getUserId(): int
    {
        if (empty($this->userId)) {
            throw new \Exception('Attribute "userId" not set');
        }
        return $this->userId;
    }

    protected function getTotalViews(): int
    {
        return Link::where('user_id', $this->getUserId())->sum('views');
    }

    protected function getTotalFiles(): int
    {
        return File::where([
            ['user_id', '=', $this->getUserId()],
        ])->count();
    }

    protected function getTotalDeletedFiles(): int
    {
        return File::onlyTrashed()->where([
            ['user_id', '=', $this->getUserId()],
        ])->count();
    }

    protected function getTotalOneTimeLinks(): int
    {
        return Link::where([
            ['user_id', '=', $this->getUserId()],
            ['single_view', '=', Link::SINGLE_VIEW]
        ])->count();
    }

    protected function getTotalUsedOneTimeLinks(): int
    {
        return Link::where([
            ['user_id', '=', $this->getUserId()],
            ['single_view', '=', Link::SINGLE_VIEW],
            ['views', '=', Link::SINGLE_VIEW]
        ])->count();
    }

}
