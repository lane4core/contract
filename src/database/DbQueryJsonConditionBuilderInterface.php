<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

/**
 * Interface for JSON-specific query condition building
 *
 * This interface provides methods for constructing JSON-specific conditions
 * such as path extraction, containment checks, and length operations.
 * All comparison methods return DbQueryBuilderInterface to continue query building.
 */
interface DbQueryJsonConditionBuilderInterface
{
    /**
     * Extracts a value from JSON using a path
     *
     * @param string $path JSON path (e.g., '$.age', '$.address.city')
     * @return self For method chaining with comparison operators
     */
    public function extract(string $path): self;

    /**
     * Checks if JSON contains a specific value
     *
     * @param mixed $value The value to search for
     * @param string|null $path Optional JSON path to search within
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function contains(
        mixed $value,
        ?string $path = null,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if JSON does NOT contain a specific value
     *
     * @param mixed $value The value to check absence of
     * @param string|null $path Optional JSON path
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function notContains(
        mixed $value,
        ?string $path = null,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Gets the length of a JSON array or object
     *
     * @param string|null $path Optional JSON path
     * @return self For method chaining with comparison operators
     */
    public function length(?string $path = null): self;

    // ==================== Comparison Operators ====================

    /**
     * Checks if the JSON value equals a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function equals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value does not equal a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function notEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is greater than a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function greater(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is greater than or equal to a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function greaterEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is lower than a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function lower(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is lower than or equal to a specific value
     *
     * @param mixed $value The value to compare
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and value is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function lowerEquals(
        mixed $value,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is in a list of values
     *
     * @param array<int, mixed> $values Array of values to check against
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and values is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function in(
        array $values,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is NOT in a list of values
     *
     * @param array<int, mixed> $values Array of values to check against
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and values is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function notIn(
        array $values,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value matches a LIKE pattern
     *
     * @param string $pattern LIKE pattern to match
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and pattern is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function like(
        string $pattern,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value does NOT match a LIKE pattern
     *
     * @param string $pattern LIKE pattern to match
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true and pattern is empty, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function notLike(
        string $pattern,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is NULL
     *
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function isNull(
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Checks if the JSON value is NOT NULL
     *
     * @param string|null $closeBracket Optional closing bracket
     * @param bool $optional If true, skips the condition
     * @return DbQueryBuilderInterface The query builder instance
     */
    public function isNotNull(
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;
}
