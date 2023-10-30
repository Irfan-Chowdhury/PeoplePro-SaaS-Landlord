<?php

use App\Services\PackageService;
use PHPUnit\Framework\Assert;

// it('matching the permission array step by step', function () {

//     $selectedPermissions = array_map(function($item) {
//         return $item['name'];
//     }, $this->selectedPermissions());
//     $nameOfSelectedSlugs = implode(',', $selectedPermissions);

//     $result = $this->featureAndPermissionManage($nameOfSelectedSlugs);

//     expect($result)->toMatchArray($this->expectedResultOfPermisson());
// });


it('matching the permission array step by step', function () {

    $selectedPermissions = array_map(function($item) {
        return $item['name'];
    }, $this->selectedPermissions());
    $nameOfSelectedSlugs = implode(',', $selectedPermissions);

    $result = $this->featureAndPermissionManage($nameOfSelectedSlugs);

    expect($result)->toMatchArray($this->expectedResultOfPermisson());
});





