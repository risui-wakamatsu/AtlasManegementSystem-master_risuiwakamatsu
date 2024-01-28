<?php

namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories
{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects)
  {
    if ($category == 'name') { //カテゴリーが名前検索なら
      if (is_null($subjects)) { //subjectsがnullなら
        $searchResults = new SelectNames();
      } else {
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    } else if ($category == 'id') { //カテゴリーがid検索なら
      if (is_null($subjects)) { //subjectsがnullなら
        $searchResults = new SelectIds();
      } else {
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    } else {
      $allUsers = new AllUsers();
      return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
