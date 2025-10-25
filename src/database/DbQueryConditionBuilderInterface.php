<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

/**
 * Interface for building conditions in SQL queries and commands.
 *
 * This interface provides methods for constructing WHERE clause conditions
 * with various comparison operators. It can be used for both SELECT queries
 * and command queries (UPDATE, DELETE).
 *
 * Most comparison operators (equals, greater, in, like, etc.) are inherited
 * from DbComparisonOperatorsInterface. This interface adds range-specific
 * operators (between, notBetween) that are unique to standard conditions.
 *
 * @package Lane4core\Contract\Database
 */
interface DbQueryConditionBuilderInterface extends DbComparisonOperatorsInterface, DbQueryExistsInterface
{
    /**
     * Constructs a condition to filter values between a specified range.
     *
     * Checks if a value falls within the inclusive range [value1, value2].
     *
     * Examples:
     * ```php
     * // Compare with literal values
     * $query->where('age')->between(18, 65);
     * $query->where('price')->between(10.00, 99.99);
     * $query->where('created_at')->between('2024-01-01', '2024-12-31');
     *
     * // Compare with columns
     * $query->where('current_price')->between('min_price', 'max_price', null, true);
     * ```
     *
     * @param mixed $value1 The lower boundary of the range (inclusive)
     * @param mixed $value2 The upper boundary of the range (inclusive)
     * @param string|null $closeBracket An optional closing bracket(s) to append to the condition
     * @param bool $isExpression If true, treats values as column names or DB functions; if false, as literal values
     * @return DbQueryBuilderInterface|DbUpdateBuilderInterface|DbDeleteBuilderInterface The builder for method chaining
     */
    public function between(
        mixed $value1,
        mixed $value2,
        ?string $closeBracket = null,
        bool $isExpression = false
    ): DbQueryBuilderInterface|DbUpdateBuilderInterface|DbDeleteBuilderInterface;

    /**
     * Constructs a condition where the value is NOT between the provided range.
     *
     * Checks if a value falls outside the inclusive range [value1, value2].
     *
     * Examples:
     * ```php
     * // Compare with literal values
     * $query->where('age')->notBetween(0, 17);  // Exclude minors
     * $query->where('score')->notBetween(40, 60);  // Exclude middle range
     *
     * // Compare with columns
     * $query->where('value')->notBetween('threshold_min', 'threshold_max', null, true);
     * ```
     *
     * @param mixed $value1 The lower boundary of the range to exclude (inclusive)
     * @param mixed $value2 The upper boundary of the range to exclude (inclusive)
     * @param string|null $closeBracket An optional closing bracket(s) to append to the condition
     * @param bool $isExpression If true, treats values as column names or DB functions; if false, as literal values
     * @return DbQueryBuilderInterface|DbUpdateBuilderInterface|DbDeleteBuilderInterface The builder for method chaining
     */
    public function notBetween(
        mixed $value1,
        mixed $value2,
        ?string $closeBracket = null,
        bool $isExpression = false
    ): DbQueryBuilderInterface|DbUpdateBuilderInterface|DbDeleteBuilderInterface;
}
