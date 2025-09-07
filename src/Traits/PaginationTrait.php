<?php

namespace Usman\N8n\Traits;

use Usman\N8n\Entities\ListingEntity;
use Usman\N8n\Response\N8nResponse;

trait PaginationTrait {

    /**
     * Append the next page of items to a ListingEntity.
     *
     * @param ListingEntity $list The current listing entity
     * @param callable $fetchPage Callback that accepts limit and cursor, returns N8nResponse
     * @param int $limit Number of items per page
     * @return N8nResponse Updated ListingEntity with next page items appended
     */
    protected function appendNextPage(ListingEntity $list, callable $fetchPage, int $limit = 100): N8nResponse {
        if (!$list->nextCursor) {
            return new N8nResponse(true, $list, 'No more pages', 200);
        }

        $resp = $fetchPage($limit, $list->nextCursor);

        if (!$resp->success) {
            return $resp;
        }

        $nextPage = $resp->data;
        $list->items = array_merge($list->items, $nextPage->items);
        $list->nextCursor = $nextPage->nextCursor;

        return new N8nResponse(true, $list, 'Next page appended', 200);
    }

    /**
     * Fetch all pages and merge them into a single ListingEntity.
     *
     * @param callable $fetchPage Callback that accepts limit and cursor, returns N8nResponse
     * @param int $limit Number of items per page
     * @return N8nResponse ListingEntity containing all pages merged
     */
    protected function listAll(callable $fetchPage, int $limit = 100): N8nResponse {
        $firstPageResp = $fetchPage($limit, null);

        if (!$firstPageResp->success) {
            return $firstPageResp;
        }

        $list = $firstPageResp->data;

        while ($list->nextCursor) {
            $resp = $this->appendNextPage($list, $fetchPage, $limit);
            if (!$resp->success) {
                return $resp;
            }
        }

        return new N8nResponse(true, $list, 'All pages fetched', 200);
    }

    /**
     * Determine whether a ListingEntity has more pages to fetch.
     *
     * @param ListingEntity $list The listing entity to check
     * @return bool True if there are more pages, false otherwise
     */
    protected function hasMore(ListingEntity $list): bool {
        return (bool) $list->nextCursor;
    }
}
