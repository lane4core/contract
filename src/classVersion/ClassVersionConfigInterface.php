<?php

declare(strict_types=1);

namespace Lane4core\Contract\ClassVersion;

interface ClassVersionConfigInterface
{
    /**
     * @param string|null $version
     * @return string|null
     */
    public function version(?string $version = null): ?string;
}
