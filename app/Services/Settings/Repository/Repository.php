<?php


namespace App\Services\Settings\Repository;


use App\Services\Settings\Setting;

interface Repository
{
    public function getAll(): array;

    public function create(Setting $setting): void;

    public function update(Setting $setting): void;

    public function delete(Setting $setting): void;
}