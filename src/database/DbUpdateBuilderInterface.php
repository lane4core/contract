<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

/**
 * Interface for building SQL UPDATE commands using a fluent interface pattern.
 *
 * This interface provides methods to construct UPDATE queries programmatically,
 * supporting WHERE conditions, JOINs (for some dialects), LIMIT, and ORDER BY.
 *
 * @package Lane4core\Contract\Database
 */
interface DbUpdateBuilderInterface extends
    DbWhereConditionInterface,
    DbJoinInterface,
    DbQueryExistsInterface,
    DbOrderLimitInterface,
    DbSqlGeneratorInterface
{
    /**
     * Specifies the table to update.
     *
     * This method defines the target table for the UPDATE operation.
     * An optional alias can be provided for use in JOINs or complex conditions.
     *
     * Example:
     * ```php
     * $command->update()->table('users', 'u');
     * ```
     *
     * @param string $container The table name
     * @param string|null $alias Optional alias for the table
     * @return self Returns the command builder instance for method chaining
     */
    public function table(string $container, ?string $alias = null): self;

    /**
     * Sets a single column to a specific value.
     *
     * Can be called multiple times to set multiple columns.
     * Values will be properly escaped and bound as parameters.
     *
     * Supported value types:
     * - Scalar values (string, int, float, bool, null): Automatically bound as prepared statement parameters
     * - DbQueryBuilderInterface: Treated as subquery and wrapped in parentheses
     *
     * Note: To use DB functions or expressions, use WHERE conditions with $isExpression = true parameter.
     *
     * Examples:
     * ```php
     * // Simple scalar values (bound as parameters)
     * $command->update()
     *     ->table('users')
     *     ->set('status', 'active')
     *     ->set('age', 25)
     *     ->set('verified', true)
     *     ->where('id')->equals(123);
     *
     * // Subquery as value
     * $maxSalary = $builder->select('MAX(salary)')
     *     ->from('employees')
     *     ->where('department')->equals('IT');
     *
     * $command->update()
     *     ->table('employees')
     *     ->set('salary', $maxSalary)
     *     ->where('department')->equals('IT');
     * ```
     *
     * @param string $field The column name to update
     * @param string|int|float|bool|null|DbQueryBuilderInterface $value The value to set
     * @return self Returns the command builder instance for method chaining
     */
    public function set(string $field, string|int|float|bool|null|DbQueryBuilderInterface $value): self;

    /**
     * Sets multiple columns using an associative array.
     *
     * Provides a convenient way to set multiple columns at once.
     * Can be called multiple times; later calls will add/override values.
     *
     * Each value in the array follows the same rules as the set() method:
     * - Scalar values: Automatically bound as prepared statement parameters
     * - DbQueryBuilderInterface: Treated as subquery and wrapped in parentheses
     *
     * Examples:
     * ```php
     * // Scalar values
     * $command->update()
     *     ->table('users')
     *     ->setMultiple([
     *         'status' => 'active',
     *         'age' => 30,
     *         'verified' => true
     *     ])
     *     ->where('id')->equals(123);
     *
     * // With subquery
     * $avgSalary = $builder->select('AVG(salary)')->from('employees');
     *
     * $command->update()
     *     ->table('employees')
     *     ->setMultiple([
     *         'salary' => $avgSalary,
     *         'bonus' => 1000
     *     ])
     *     ->where('active')->equals(1);
     * ```
     *
     * @param array<string, string|int|float|bool|null|DbQueryBuilderInterface> $data array of column => value pairs
     * @return self Returns the command builder instance for method chaining
     */
    public function setMultiple(array $data): self;
}
