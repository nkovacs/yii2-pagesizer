<?php

namespace nkovacs\pagesizer;

use Yii;
use yii\web\Request;

/**
 * Helper class to create an url with the specified page size.
 */
class PageSize
{
    /**
     * Creates an url for the specified page size.
     * @param \yii\data\Pagination $pagination
     * @param integer $pageSize page size
     * @param boolean $absolute whether to create an absolute URL. Defaults to `false`.
     *
     * @return string the created URL
     */
    public static function createSizeUrl($pagination, $pageSize, $absolute = false)
    {
        if (($params = $pagination->params) === null) {
            $request = Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }

        $currentPageSize = $pagination->getPageSize();
        $currentPage = $pagination->getPage();
        $target = $currentPage*$currentPageSize;
        $page = (int)($target/$pageSize);

        if ($page > 0 || $page >= 0 && $pagination->forcePageParam) {
            $params[$pagination->pageParam] = $page + 1;
        } else {
            unset($params[$pagination->pageParam]);
        }
        if ($pageSize != $pagination->defaultPageSize) {
            $params[$pagination->pageSizeParam] = $pageSize;
        } else {
            unset($params[$pagination->pageSizeParam]);
        }

        $params[0] = $pagination->route === null ? Yii::$app->controller->getRoute() : $pagination->route;
        $urlManager = $pagination->urlManager === null ? Yii::$app->getUrlManager() : $pagination->urlManager;
        if ($absolute) {
            return $urlManager->createAbsoluteUrl($params);
        } else {
            return $urlManager->createUrl($params);
        }
    }
}
