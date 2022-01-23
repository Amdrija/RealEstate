<?php

namespace Amdrija\RealEstate\Application\RequestModels;

class PaginatedResponse
{
    public int $page;
    public int $pageSize;
    public int $pageCount;
    public array $data;

    public function __construct(Pagination $pagination, array $data)
    {
        $this->page = min($pagination->page, $pagination->pageCount);
        $this->pageSize = $pagination->pageSize;
        $this->pageCount = $pagination->pageCount;
        $this->data = $data;
    }
}