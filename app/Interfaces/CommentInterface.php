<?php

namespace App\Interfaces;

use App\Interfaces\Base\CreateInterface;
use App\Interfaces\Base\DeleteInterface;
use App\Interfaces\Base\FindInterface;
use App\Interfaces\Base\UpdateInterface;

interface CommentInterface extends CreateInterface, UpdateInterface, FindInterface ,DeleteInterface
{
    public function deleteByPost(int $id): void;
}