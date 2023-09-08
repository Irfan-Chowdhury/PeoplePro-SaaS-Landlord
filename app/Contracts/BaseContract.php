<?php

namespace App\Contracts;

// $this->languageId
interface BaseContract {
    public function all();

    public function getSelectData($selectedData);

    // BlogController || LandingPageController
    public function getAllByLanguageId($languageId);

    public function getAllWithRelation($relation);

    public function fetchLatestDataByLanguageId($languageId);

    public function fetchLatestDataBySlug($slug);

    public function fetchLatestDataByLanguageIdWithRelation($relation, $languageId);

    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getMaxPosition();

    public function getOrderByPosition();

    public function fetchLatestData();

    public function latestDataUpdate(array $data);

    public function updateOrCreate($condition, $data);


    // Add other specific methods here as needed
}
