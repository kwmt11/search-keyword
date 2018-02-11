<?php

namespace App\Libs;

use App\Http\Models\Activity;
use App\Http\Models\Page;
use App\Http\Models\User;

class PageUtility
{
    /**
     * 検索
     *
     * @param $keyword
     * @return array
     */
    public static function findUserViewedPage($keyword){
        $pageModel = new Page();
        $pages = $pageModel->getPagesByKeywordMapById($keyword);
        $pageIds = $pages->keys()->toArray();

        $activityModel = new Activity();
        $activities = $activityModel->getActivitiesByPageIds($pageIds);

        $userIds = [];
        foreach ($activities as $active) {
          $userIds[] = $active->user_id;
        }
        $userModel = new User();
        $users = $userModel->getUsersMapById($userIds);

        $userPageMap = [];
        $foundPageIds = [];
        foreach ($activities as $active) {
          $userId = $active->user_id;
          $pageId = $active->page_id;
          if (!empty($userPageMap[$userId])) {
              $userPageMap[$userId]['view_count'] = $userPageMap[$userId]['view_count']+1;
          } else {
              if (!in_array($pageId, $foundPageIds)) {
                  $foundPageIds[] = $pageId;
              }
              $userPageMap[$userId] = [];
              $userPage = [];
              $userPage['page_id'] = $pages[$pageId]->id;
              $userPage['page_title'] = $pages[$pageId]->title;
              $userPage['user_id'] = $userId;
              $userPage['user_name'] = $users[$userId]->name;
              $userPage['view_count'] = 1;
              $userPageMap[$userId] = $userPage;
          }
        }

        $userPageArray = [];
        $notFoundPageIds = array_diff($pageIds, $foundPageIds);
        foreach ($notFoundPageIds as $pageId) {
            $userPage = [];
            $userPage['page_id'] = $pages[$pageId]->id;
            $userPage['page_title'] = $pages[$pageId]->title;
            $userPageArray[] = $userPage;
        }

        foreach ($userPageMap as $userPage) {
            $userPageArray[] = $userPage;
        }

        return $userPageArray;
    }
}
