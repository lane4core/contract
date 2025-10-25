<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

/**
 * Interface for WHERE condition methods in SQL query builders.
 *
 * This interface provides methods to add WHERE, AND, and OR conditions
 * to SQL queries, including support for both standard and JSON-based conditions.
 * It implements the Interface Segregation Principle by isolating condition-related
 * functionality that is shared across SELECT, UPDATE, and DELETE query builders.
 *
 * @package Lane4core\Contract\Database
 */
interface DbWhereConditionInterface
{
    /**
     * Starts a WHERE condition clause.
     *
     * Initiates a condition chain by specifying the column to compare.
     * If no column is provided, it can be used to add EXISTS or other
     * standalone conditions. Returns a condition builder for specifying
     * the comparison operator and value.
     *
     * Example:
     * ```php
     * $query->where('status')->equals('active');
     * $query->where('age')->greaterThan(18);
     * $query->where('name', '(')->like('%John%')->or('name')->like('%Jane%', ')');
     * ```
     *
     * @param string|null $field The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions (e.g., '(' or '((')
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function where(?string $field = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Adds an AND condition to the WHERE clause.
     *
     * Chains an additional condition with AND logic. Can be called after
     * any condition method that returns the query builder. If no column
     * is provided, can be used for standalone conditions like EXISTS.
     *
     * Example:
     * ```php
     * $query->where('status')->equals('active')
     *       ->and('age')->greaterThan(18);
     * ```
     *
     * @param string|null $field The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function and(?string $field = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Adds an OR condition to the WHERE clause.
     *
     * Chains an alternative condition with OR logic. Can be called after
     * any condition method that returns the query builder. If no column
     * is provided, can be used for standalone conditions like EXISTS.
     *
     * Example:
     * ```php
     * $query->where('status')->equals('active')
     *       ->or('status')->equals('pending');
     * ```
     *
     * @param string|null $field The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function or(?string $field = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Starts a JSON-specific WHERE condition.
     *
     * Initiates a condition chain for JSON column data, enabling JSON path
     * expressions and JSON-specific comparison operators.
     *
     * Example:
     * ```php
     * $query->whereJson('metadata')->path('$.user.name')->equals('John');
     * $query->whereJson('settings')->contains(['theme' => 'dark']);
     * ```
     *
     * @param string $field The JSON column name
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryJsonConditionBuilderInterface Returns the JSON condition builder for JSON-specific operations
     */
    public function whereJson(string $field, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Starts a JSON-specific AND condition.
     *
     * Chains an additional JSON condition with AND logic.
     *
     * Example:
     * ```php
     * $query->whereJson('metadata')->path('$.user.role')->equals('admin')
     *       ->andJson('metadata')->path('$.user.active')->equals(true);
     * ```
     *
     * @param string $field The JSON column name
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryJsonConditionBuilderInterface Returns the JSON condition builder for JSON-specific operations
     */
    public function andJson(string $field, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Starts a JSON-specific OR condition.
     *
     * Chains an alternative JSON condition with OR logic.
     *
     * Example:
     * ```php
     * $query->whereJson('metadata')->path('$.status')->equals('active')
     *       ->orJson('metadata')->path('$.status')->equals('pending');
     * ```
     *
     * @param string $field The JSON column name
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryJsonConditionBuilderInterface Returns the JSON condition builder for JSON-specific operations
     */
    public function orJson(string $field, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;
}
