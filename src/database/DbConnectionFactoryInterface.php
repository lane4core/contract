<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

use PDOException;
use InvalidArgumentException;

interface DbConnectionFactoryInterface
{
    /**
     * Supported database drivers
     */
    public const DRIVER_MYSQL = 'mysql';
    public const DRIVER_PGSQL = 'pgsql';
    public const DRIVER_SQLITE = 'sqlite';

    /**
     * Common configuration keys
     */
    public const CONFIG_HOST = 'host';
    public const CONFIG_PORT = 'port';
    public const CONFIG_DATABASE = 'database';
    public const CONFIG_USER = 'user';
    public const CONFIG_PASSWORD = 'password';
    public const CONFIG_CHARSET = 'charset';
    public const CONFIG_PATH = 'path';
    public const CONFIG_OPTIONS = 'options';

    /**
     * Creates a new database connection for the specified driver.
     *
     * Each call creates a fresh connection instance.
     * For connection pooling, use a separate pool implementation.
     *
     * Expected configuration by driver:
     * - mysql/pgsql: host, port, database, username, password, charset (optional), options (optional)
     * - sqlite: path, options (optional)
     *
     * @param self::DRIVER_* $driver The database driver (use DRIVER_* constants)
     * @param array<string, mixed> $config Driver-specific configuration
     * @return DbConnectionInterface A new database connection
     * @throws PDOException if the connection cannot be established
     * @throws InvalidArgumentException if a driver is not supported or config is invalid
     */
    public function create(string $driver, array $config): DbConnectionInterface;

    /**
     * Gets a list of supported database drivers.
     *
     * @return array<string> List of supported driver names
     */
    public function getSupportedDrivers(): array;

    /**
     * Checks if a driver is supported.
     *
     * @param string $driver The driver names to check
     * @return bool True if the driver is supported
     */
    public function supportsDriver(string $driver): bool;
}
