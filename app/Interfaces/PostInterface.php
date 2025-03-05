<?php

namespace App\Interfaces;

use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\UpdateInterface;
use Illuminate\Database\Eloquent\Collection;

interface PostInterface extends CreateInterface, UpdateInterface, DeleteInterface, FindInterface
{
    public function getAll(string $category): Collection;
}