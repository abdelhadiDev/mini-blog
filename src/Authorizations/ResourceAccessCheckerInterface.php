<?php

declare(strict_types=1);

namespace App\Authorizations;

interface ResourceAccessCheckerInterface
{
    const ERROR_MESSAGE = "It's not your ressource";

    public function canAccess(?int $id): void;
}