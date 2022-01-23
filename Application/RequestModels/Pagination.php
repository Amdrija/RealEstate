<?php

namespace Amdrija\RealEstate\Application\RequestModels;

class Pagination
{
    public int $page;
    public int $pageSize;
    public int $pageCount;
    private const DEFAULT_PAGE_SIZE = 10;
    private const MAXIMUM_PAGE_SIZE = 50;

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->pageSize;
    }

    public static function create(array $queryParameters, int $dataCount): Pagination
    {
        $pagination = new Pagination();
        $pagination->pageSize = isset($queryParameters['pageSize']) ? intval($queryParameters['pageSize']) : self::DEFAULT_PAGE_SIZE;
        if($pagination->pageSize > self::MAXIMUM_PAGE_SIZE) {
            $pagination->pageSize = self::MAXIMUM_PAGE_SIZE;
        }

        $pagination->page = isset($queryParameters['page']) ? intval($queryParameters['page']) : 1;

        $pagination->pageCount = ceil($dataCount / $pagination->pageSize);
        if($pagination->page > $pagination->pageCount) {
            $pagination->page = $pagination->pageCount;
        }

        return $pagination;
    }
}