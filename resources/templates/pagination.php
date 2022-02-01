<?php
/**
 * @var PaginatedResponse $paginatedResponse
 */

use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;

/**
 * Parses the REQUEST_URI to get the query parameters array.
 * @return array
 */
function parseUrlForQueryParameters(): array
{
    $uriString = parse_url($_SERVER['REQUEST_URI']);
    $queryString = $uriString['query'] ?? "";
    parse_str($queryString, $query);

    return $query;
}

function constructQuery(int $page, int $pageSize)
{
    $query = parseUrlForQueryParameters();
    $query['page'] = $page;
    $query['pageSize'] = $pageSize;

    $s = "?" . http_build_query($query);
    return $s;
}

function constructQueryForFirstPage(int $pageSize)
{
    return constructQuery(1, $pageSize);
}

function constructQueryForPreviousPage(int $currentPage, int $pageSize)
{
    $previousPage = $currentPage > 1 ? $currentPage - 1 : 1;

    return constructQuery($previousPage, $pageSize);
}

function constructQueryForNextPage(int $currentPage, int $pageCount, int $pageSize)
{
    $nextPage = $currentPage < $pageCount ? $currentPage + 1 : $pageCount;

    return constructQuery($nextPage, $pageSize);
}

function constructQueryForLastPage(int $pageCount, int $pageSize)
{
    return constructQuery($pageCount, $pageSize);
}

?>
<ul class="uk-pagination uk-flex-center" uk-margin>
    <li><a href="<?= constructQueryForPreviousPage($paginatedResponse->page, $paginatedResponse->pageSize) ?>"><span uk-pagination-previous></span></a></li>
    <?php if($paginatedResponse->page > 1):?>
        <li><a href="<?= constructQueryForFirstPage($paginatedResponse->pageSize) ?>">1</a></li>
        <li class="uk-disabled"><span>...</span></li>
    <?php endif;?>
    <li class="uk-active"><a href="#"><?= $paginatedResponse->page ?></a></li>
    <?php if($paginatedResponse->page < $paginatedResponse->pageCount):?>
        <li class="uk-disabled"><span>...</span></li>
        <li><a href="<?= constructQueryForLastPage($paginatedResponse->pageCount, $paginatedResponse->pageSize) ?>"><?= $paginatedResponse->pageCount?></a></li>
    <?php endif;?>
    <li><a href="<?= constructQueryForNextPage(
            $paginatedResponse->page,
            $paginatedResponse->pageCount,
            $paginatedResponse->pageSize
        ) ?>"><span uk-pagination-next></span></a></li>
</ul>