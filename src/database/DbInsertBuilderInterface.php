<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

use InvalidArgumentException;

/**
 * Interface for building SQL INSERT commands using a fluent interface pattern.
 *
 * This interface provides methods to construct INSERT queries programmatically,
 * supporting single-row inserts, multi-row inserts, and INSERT...SELECT operations.
 *
 * Note: INSERT commands do NOT support WHERE, JOIN, or HAVING clauses.
 *
 * @package Lane4core\Contract\Database
 */
interface DbInsertBuilderInterface extends DbQueryExistsInterface, DbSqlGeneratorInterface
{
    /**
     * Specifies the table to insert data into.
     *
     * This method defines the target table for the INSERT operation.
     *
     * Example:
     * ```php
     * $command->insert()->into('users');
     * ```
     *
     * @param string $container The table name
     * @return self Returns the command builder instance for method chaining
     */
    public function into(string $container): self;

    /**
     * Specifies the columns for the INSERT operation.
     *
     * This method defines which columns will receive values. The order of columns
     * must match the order of values in the values() method.
     *
     * Example:
     * ```php
     * $command->insert()->into('users')->columns('name', 'email', 'status');
     * ```
     *
     * @param string ...$fields One or more column names
     * @return self Returns the command builder instance for method chaining
     */
    public function columns(string ...$fields): self;

    /**
     * Adds a single row of values to insert.
     *
     * Can be called multiple times to insert multiple rows in one query.
     * The number and order of values must match the columns defined in columns().
     *
     * Examples:
     * ```php
     * $command->insert()
     *     ->into('users')
     *     ->columns('name', 'email', 'status')
     *     ->values('John Doe', 'john@example.com', 'active')
     *     ->values('Jane Smith', 'jane@example.com', 'active');
     * ```
     *
     * @param mixed ...$values The values to insert
     * @return self Returns the command builder instance for method chaining
     * @throws InvalidArgumentException If number of values doesn't match number of columns
     */
    public function values(mixed ...$values): self;

    /**
     * Sets column-value pairs for a single-row insert using an associative array.
     *
     * Provides an alternative to columns() + values() for single-row inserts.
     * Multiple calls will override previous values, not add rows.
     *
     * Example:
     * ```php
     * $command->insert()
     *     ->into('users')
     *     ->set([
     *         'name' => 'John Doe',
     *         'email' => 'john@example.com',
     *         'status' => 'active'
     *     ]);
     * ```
     *
     * @param array<string, mixed> $data Associative array of column => value pairs
     * @return self Returns the command builder instance for method chaining
     */
    public function set(array $data): self;

    /**
     * Uses a SELECT query as the source for INSERT data.
     *
     * The SELECT query must return columns that match the columns specified
     * in columns() method, or match the table's column order if columns() is not used.
     *
     * Example:
     * ```php
     * $selectQuery = $query->select('name, email')
     *     ->from('temp_users')
     *     ->where('status')->equals('pending');
     *
     * $command->insert()
     *     ->into('users')
     *     ->columns('name', 'email')
     *     ->fromSelect($selectQuery);
     * ```
     *
     * @param DbQueryBuilderInterface $query The SELECT query providing the data
     * @return self Returns the command builder instance for method chaining
     */
    public function fromSelect(DbQueryBuilderInterface $query): self;
}
