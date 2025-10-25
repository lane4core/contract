<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

/**
 * Factory interface for building SQL command queries (INSERT, UPDATE, DELETE).
 *
 * This interface provides factory methods to create specific command builders
 * for different SQL operations, following the Command pattern and CQRS principles.
 *
 * Usage:
 * ```php
 * $command = new DbCommand();
 * $command->insert()->into('users')->set(['name' => 'John']);
 * $command->update()->table('users')->set('status', 'active')->where('id')->equals(1);
 * $command->delete()->from('users')->where('id')->equals(1);
 * ```
 *
 * @package Lane4core\Contract\Database
 */
interface DbCommandBuilderInterface
{
    /**
     * Creates a new INSERT command builder.
     *
     * Returns a builder for constructing INSERT queries with support for:
     * - Single and multi-row inserts
     * - INSERT...SELECT operations
     * - ON DUPLICATE KEY UPDATE (MySQL/MariaDB)
     *
     * @return DbInsertBuilderInterface The INSERT command builder
     */
    public function insert(): DbInsertBuilderInterface;

    /**
     * Creates a new UPDATE command builder.
     *
     * Returns a builder for constructing UPDATE queries with support for:
     * - WHERE conditions
     * - JOINs (database-dependent)
     * - LIMIT and ORDER BY (MySQL/MariaDB)
     *
     * @return DbUpdateBuilderInterface The UPDATE command builder
     */
    public function update(): DbUpdateBuilderInterface;

    /**
     * Creates a new DELETE command builder.
     *
     * Returns a builder for constructing DELETE queries with support for:
     * - WHERE conditions
     * - JOINs (database-dependent)
     * - LIMIT and ORDER BY (MySQL/MariaDB)
     *
     * @return DbDeleteBuilderInterface The DELETE command builder
     */
    public function delete(): DbDeleteBuilderInterface;
}
