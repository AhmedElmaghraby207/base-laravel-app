<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CommonHelper
{
    public static function customPagination($data)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);
        // Define how many items we want to be visible in each page
        $perPage = 10;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator(collect($currentPageItems)->values(), count($itemCollection), $perPage);
        // set url path for generted links
        return $paginatedItems;
    }

    public static function customPaginationByTotal($data, $perPage, $total)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);
        // Define how many items we want to be visible in each page
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator(collect($currentPageItems)->values(), $total, $perPage);
        // set url path for generted links
        $paginatedItems->setPath(\Request::url());
        $paginatedItems = $paginatedItems->toArray();
        $paginatedItems["data"] = $data;
        $from = (($currentPage - 1) * $perPage);
        $paginatedItems["from"] = $from + 1;
        $paginatedItems["to"] = ($total > $from + $perPage) ? $from + $perPage : $total;
        return $paginatedItems;
    }

    public static function customPagination_datatable($query)
    {
        $request = app(Request::class);
        $length = $request->length ?: 10;
        $page = ($request->start / $length) + 1 ?: 1; /* Actual page */
        $limit = $length; /* Limit per page */
        $paged = $query->paginate($limit, ['*1'], 'page', $page);
        $total = $paged->total();
        $output = array(
            "draw" => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => collect($paged)['data'],
            "input" => []
        );
        return $output;
    }

    public static function indexingCollection($collect, $startIndex = 0)
    {
        $collect = collect($collect)->toArray();
        $count = count($collect);
        for ($i = 1; $i <= $count; $i++) {
            $collect[$i - 1]["sort"] = $i + $startIndex;
        }
        return collect($collect);
    }

}
