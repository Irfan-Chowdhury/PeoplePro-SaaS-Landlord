<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function getSelectData($selectedData) : Collection
    {
        return $this->model->select($selectedData)->get();
    }

    // BlogController
    public function getAllByLanguageId($languageId)
    {
        return $this->model->where('language_id',$languageId)->get();
    }

    public function getAllWithRelation($relation)
    {
        return $this->model->with($relation)->get();
    }

    // GeneralSettingController
    public function fetchLatestData()
    {
        return $this->model->latest()->first();
    }

    // ModuleController ||  FaqController || TenantSignUpController || LandingPageController
    public function fetchLatestDataByLanguageId($languageId)
    {
        return $this->model->where('language_id',$languageId)->latest()->first();
    }

    // LandingpageController: pageDetails()
    public function fetchLatestDataBySlug($slug)
    {
        return $this->model->where('slug',$slug)->latest()->first();
    }

    // ModuleController || FaqController
    public function fetchLatestDataByLanguageIdWithRelation($relation, $languageId)
    {
        return $this->model->with($relation)->where('language_id',$languageId)->latest()->first();
    }

    // GeneralSettingController
    public function latestDataUpdate(array $data) : void
    {
        $this->fetchLatestData()->update($data);
    }


    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data): void
    {
        $this->model->create($data);
    }

    // Module Service
    public function update($id, array $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    // Feature
    public function getMaxPosition() :int
    {
        return $this->model->max('position') ?? 0;
    }


    // Feature || LandlordController ||  TestimonialController || LandingPageController
    public function getOrderByPosition()
    {
        return $this->model->orderBy('position','ASC')->get();
    }

    // ModuleController || TenantSignUpController || SettingController:
    public function updateOrCreate($condition, $data) : void
    {
        $this->model->updateOrCreate($condition, $data);
    }





    // public function productsWithCategory() {
    //     // Specific implementation for "Product with Category" scenario
    //     return Product::with('category')->get();
    // }

    // Each specific repository must implement this method to provide the model class
    // abstract protected function getModelClass();
}
