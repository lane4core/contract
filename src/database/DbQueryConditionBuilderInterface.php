<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

interface DbQueryConditionBuilderInterface extends DbQuerySharedInterface
{
    /**
     * Adds a condition to the query to check if a value is greater than the specified parameter.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional closing bracket to append to the condition.
     * @param bool $optional Determines whether the condition is optional. If true, the condition
     *        is included only if $compare exists; otherwise, the condition is always included.
     * @return DbQueryBuilderInterface The instance of the query builder with the added condition.
     */
    public function greater(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Adds a condition to the query to check if a value is greater than or equal to the specified parameter.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional closing bracket to append to the condition.
     * @param bool $optional Determines whether the condition is optional. If true, the condition
     *        is included only if $compare exists; otherwise, the condition is always included.
     * @return DbQueryBuilderInterface The instance of the query builder with the added condition.
     */
    public function greaterEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Adds a condition to the query to check if a value is less than the specified parameter.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional closing bracket to append to the condition.
     * @param bool $optional Determines whether the condition is optional. If true, the condition
     *        is included only if $compare exists; otherwise, the condition is always included.
     * @return DbQueryBuilderInterface The instance of the query builder with the added condition.
     */
    public function lower(mixed $value, ?string $closeBracket = null, bool $optional = false): DbQueryBuilderInterface;

    /**
     * Adds a condition to the query to check if a value is less than or equal to the specified parameter.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional closing bracket to append to the condition.
     * @param bool $optional Determines whether the condition is optional. If true, the condition
     *        is included only if $compare exists; otherwise, the condition is always included.
     * @return DbQueryBuilderInterface The instance of the query builder with the added condition.
     */
    public function lowerEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Adds a condition to the query to check if a value is equal to the specified parameter.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional closing bracket to append to the condition.
     * @param bool $optional Determines whether the condition is optional. If true, the condition
     *        is included only if $compare exists; otherwise, the condition is always included.
     * @return DbQueryBuilderInterface The instance of the query builder with the added condition.
     */
    public function equals(mixed $value, ?string $closeBracket = null, bool $optional = false): DbQueryBuilderInterface;

    /**
     * Constructs a condition where the value is not equal to the provided comparison value.
     *
     * @param mixed $value The value to compare against.
     * @param ?string $closeBracket An optional string to append to the condition for closing brackets
     * or additional formatting.
     * @param bool $optional Determines if the comparison is optional; if true and $value is null or empty,
     * no condition will be added.
     * @return DbQueryBuilderInterface The modified query builder instance with the not-equals condition.
     */
    public function notEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Constructs a condition to filter values between a specified range.
     *
     * @param mixed $value1 The lower boundary of the range.
     * @param mixed $value2 The upper boundary of the range.
     * @param ?string $closeBracket An optional string to append to the condition for closing brackets
     * or additional formatting.
     * @param bool $optional Determines if the condition is optional; if true and $value1 or $value2
     * it is null or empty, no condition will be added.
     * @return DbQueryBuilderInterface The modified query builder instance with the between condition.
     */
    public function between(
        mixed $value1,
        mixed $value2,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Constructs a condition where the value is not between the provided range.
     *
     * @param mixed $value1 The starting value of the range for comparison.
     * @param mixed $value2 The ending value of the range for comparison.
     * @param ?string $closeBracket An optional string to append to the condition for closing brackets
     * or additional formatting.
     * @param bool $optional Determines if the condition is optional; if true and $value1 is null or empty,
     * no condition will be added.
     * @return DbQueryBuilderInterface The modified query builder instance with the not-between condition.
     */
    public function notBetween(
        mixed $value1,
        mixed $value2,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Constructs a condition where the value is checked for inclusion within a specified set of values or subquery.
     *
     * Accepts either an array of values or a subquery builder for dynamic value lists.
     * When using a subquery, the subquery should return a single column.
     *
     * Examples:
     * - Array: ['active', 'pending', 'approved']
     * - Subquery: A DbQueryBuilderInterface instance returning a single column
     *
     * @param array<mixed>|DbQueryBuilderInterface $value Array of values or subquery returning values to check against
     * @param ?string $closeBracket An optional string to append to the condition for closing brackets
     * or additional formatting.
     * @param bool $optional Determines if the condition is optional; if true and $value is null or empty,
     * no condition will be added.
     * @return DbQueryBuilderInterface The modified query builder instance with the IN condition.
     */
    public function in(
        array|DbQueryBuilderInterface $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Generates a NOT IN conditional clause for a query with values or subquery.
     *
     * Accepts either an array of values or a subquery builder for dynamic exclusion lists.
     * When using a subquery, the subquery should return a single column.
     *
     * Examples:
     * - Array: ['inactive', 'deleted', 'banned']
     * - Subquery: A DbQueryBuilderInterface instance returning a single column
     *
     * @param array<mixed>|DbQueryBuilderInterface $value Array of values or subquery returning values to exclude
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if a value is provided or determined.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function notIn(
        array|DbQueryBuilderInterface $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Generates a LIKE conditional clause for a query.
     *
     * @param mixed $value The value to be included in the LIKE clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if a value is provided or determined.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function like(mixed $value, ?string $closeBracket = null, bool $optional = false): DbQueryBuilderInterface;

    /**
     * Generates a NOT LIKE conditional clause for a query.
     *
     * @param mixed $value The value to be used in the NOT LIKE clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if a value is provided or determined.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function notLike(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Generates an IS NULL conditional clause for a query.
     *
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if specified criteria are met.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function isNull(
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Ensures that a specific condition is not null within the query.
     *
     * This method adds a non-null constraint to the query, optionally
     * including a closing bracket or making it part of an optional condition,
     * as specified by the parameters.
     *
     * @param ?string $closeBracket An optional string representing a closing bracket
     *                              to be included in the query. Defaults to an empty string.
     * @param bool $optional Determines whether the non-null constraint should be
     *                        treated as optional. Defaults to false.
     *
     * @return DbQueryBuilderInterface Returns the current instance of the query builder
     *                                  for method chaining.
     */
    public function isNotNull(?string $closeBracket = null, bool $optional = false): DbQueryBuilderInterface;
}
