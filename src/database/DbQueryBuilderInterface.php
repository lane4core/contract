<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

use InvalidArgumentException;

/**
 * Interface for building SQL SELECT queries using a fluent interface pattern.
 *
 * This interface provides methods to construct complex SQL queries programmatically,
 * supporting all major SQL clauses including SELECT, FROM, WHERE, JOIN, GROUP BY,
 * HAVING, ORDER BY, LIMIT, and UNION operations.
 *
 * @package Lane4core\Contract\Database
 */
interface DbQueryBuilderInterface extends DbQuerySharedInterface
{
    /**
     * Adds a Common Table Expression (CTE) to the query using WITH clause.
     *
     * CTEs allow you to define temporary named result sets that can be referenced
     * within the main query. Multiple CTEs can be added by calling this method
     * multiple times. CTEs are executed before the main query and improve readability
     * of complex queries.
     *
     * Examples:
     * ```php
     * $activeUsers = $builder->select('id, name')->from('users')->where('active')->equals(1);
     * $query->with('active_users', $activeUsers)
     *       ->select('*')
     *       ->from('active_users');
     * ```
     *
     * Multiple CTEs:
     * ```php
     * $query->with('cte1', $subquery1)
     *       ->with('cte2', $subquery2)
     *       ->select('*')
     *       ->from('cte1')
     *       ->innerJoin('cte2', 'cte1.id = cte2.id');
     * ```
     *
     * @param string $name The name of the CTE (used to reference it in the main query)
     * @param DbQueryBuilderInterface $query The subquery that defines the CTE
     * @return self Returns the query builder instance for method chaining
     */
    public function with(string $name, DbQueryBuilderInterface $query): self;

    /**
     * Adds a recursive Common Table Expression (CTE) to the query using WITH RECURSIVE.
     *
     * Recursive CTEs are used for hierarchical or tree-structured data, such as
     * organizational charts, category trees, or graph traversal. The subquery
     * typically contains a UNION between an anchor member (base case) and a
     * recursive member that references the CTE itself.
     *
     * Note: Not all databases support recursive CTEs (MySQL 8.0+, PostgresSQL, SQLite 3.8.3+).
     *
     * Example (organizational hierarchy):
     * ```php
     * $recursive = $builder
     *     ->select('id, name, manager_id, 1 as level')
     *     ->from('employees')
     *     ->where('manager_id')->isNull()
     *     ->unionAll(
     *         $builder->select('e.id, e.name, e.manager_id, r.level + 1')
     *             ->from('employees', 'e')
     *             ->innerJoin('org_tree', 'e.manager_id = r.id', 'r')
     *     );
     *
     * $query->withRecursive('org_tree', $recursive)
     *       ->select('*')
     *       ->from('org_tree')
     *       ->orderBy('level');
     * ```
     *
     * @param string $name The name of the recursive CTE
     * @param DbQueryBuilderInterface $query The recursive subquery (must contain UNION)
     * @return self Returns the query builder instance for method chaining
     */
    public function withRecursive(string $name, DbQueryBuilderInterface $query): self;

    /**
     * Specifies the columns to select in the query.
     *
     * This method defines the SELECT clause of the SQL query. Multiple columns
     * can be specified as a comma-separated string. Supports SQL functions,
     * aliases, and expressions.
     *
     * @param string $fields The column names or expressions to select (e.g., 'id, name, COUNT(*) as total')
     * @return self Returns the query builder instance for method chaining
     */
    public function select(string $fields): self;

    /**
     * Includes a subquery in the SELECT clause.
     *
     * Adds a correlated or non-correlated subquery as a column in the result set.
     * The subquery must return a single value (scalar subquery).
     *
     * @param DbQueryBuilderInterface $query The subquery to include in SELECT
     * @param string $alias Required alias for the subquery column
     * @return self Returns the query builder instance for method chaining
     */
    public function selectSubquery(DbQueryBuilderInterface $query, string $alias): self;

    /**
     * Adds the DISTINCT keyword to the SELECT clause.
     *
     * When enabled, duplicate rows in the result set will be eliminated.
     * This should be called before or after select() method.
     *
     * @param bool $isDistinctQuery Whether to make this a DISTINCT query (default: false)
     * @return self Returns the query builder instance for method chaining
     */
    public function distinct(bool $isDistinctQuery = false): self;

    /**
     * Specifies the table or subquery to query from (FROM clause).
     *
     * Defines the primary data source for the query. Can accept either a table name
     * or a subquery builder instance. An optional alias can be provided to reference
     * the data source in JOINs and WHERE clauses.
     *
     * When using a subquery, an alias is required and will be enforced by the implementation.
     * For table names, the alias is optional.
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to query from
     * @param string|null $alias Alias for the data source (required for subqueries, optional for tables)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function from(string|DbQueryBuilderInterface $container, ?string $alias = null): self;

    /**
     * Starts a WHERE condition clause.
     *
     * Initiates a condition chain by specifying the column to compare.
     * If no column is provided, it can be used to add EXISTS or other
     * standalone conditions. Returns a condition builder for specifying
     * the comparison operator and value.
     *
     * @param string|null $column The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions (e.g., '(' or '((')
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function where(?string $column = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Adds an AND condition to the WHERE clause.
     *
     * Chains an additional condition with AND logic. Can be called after
     * any condition method that returns the query builder. If no column
     * is provided, can be used for standalone conditions like EXISTS.
     *
     * @param string|null $column The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function and(?string $column = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Adds an OR condition to the WHERE clause.
     *
     * Chains an alternative condition with OR logic. Can be called after
     * any condition method that returns the query builder. If no column
     * is provided, can be used for standalone conditions like EXISTS.
     *
     * @param string|null $column The column name to compare (optional for EXISTS)
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function or(?string $column = null, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Starts a JSON-specific WHERE condition
     *
     * @param string $column The JSON column name
     * @param string|null $openBracket Optional opening bracket(s)
     * @return DbQueryJsonConditionBuilderInterface For JSON-specific operations
     */
    public function whereJson(string $column, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Starts a JSON-specific AND condition
     *
     * @param string $column The JSON column name
     * @param string|null $openBracket Optional opening bracket(s)
     * @return DbQueryJsonConditionBuilderInterface For JSON-specific operations
     */
    public function andJson(string $column, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Starts a JSON-specific OR condition
     *
     * @param string $column The JSON column name
     * @param string|null $openBracket Optional opening bracket(s)
     * @return DbQueryJsonConditionBuilderInterface For JSON-specific operations
     */
    public function orJson(string $column, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Starts a JSON-specific HAVING condition
     *
     * @param string $column The JSON column name
     * @param string|null $openBracket Optional opening bracket(s)
     * @return DbQueryJsonConditionBuilderInterface For JSON-specific operations
     */
    public function havingJson(string $column, ?string $openBracket = null): DbQueryJsonConditionBuilderInterface;

    /**
     * Adds an INNER JOIN clause to the query.
     *
     * Joins another table using INNER JOIN, returning only rows where the
     * join condition matches in both tables.
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to join
     * @param string $constraint The join condition (e.g., 'orders.user_id = users.id')
     * @param string|null $alias Optional alias for the joined table (required for subqueries)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function innerJoin(
        string|DbQueryBuilderInterface $container,
        string $constraint,
        ?string $alias = null
    ): self;

    /**
     * Adds a LEFT JOIN clause to the query.
     *
     * Joins another table or subquery using LEFT JOIN (LEFT OUTER JOIN), returning all rows
     * from the left table and matching rows from the right table (NULL if no match).
     *
     * When using a subquery, an alias is required and will be enforced by the implementation.
     *
     * Examples:
     * - Table: leftJoin('orders', 'orders.user_id = users.id', 'o')
     * - Subquery: leftJoin($subquery, 'subq.id = users.id', 'subq')
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to join
     * @param string $constraint The join condition (e.g., 'orders.user_id = users.id')
     * @param string|null $alias Optional alias for the joined table (required for subqueries)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function leftJoin(
        string|DbQueryBuilderInterface $container,
        string $constraint,
        ?string $alias = null
    ): self;

    /**
     * Adds a RIGHT JOIN clause to the query.
     *
     * Joins another table or subquery using RIGHT JOIN (RIGHT OUTER JOIN), returning all rows
     * from the right table and matching rows from the left table (NULL if no match).
     *
     * When using a subquery, an alias is required and will be enforced by the implementation.
     *
     * Examples:
     * - Table: rightJoin('orders', 'orders.user_id = users.id', 'o')
     * - Subquery: rightJoin($subquery, 'subq.id = users.id', 'subq')
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to join
     * @param string $constraint The join condition (e.g., 'orders.user_id = users.id')
     * @param string|null $alias Optional alias for the joined table (required for subqueries)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function rightJoin(
        string|DbQueryBuilderInterface $container,
        string $constraint,
        ?string $alias = null
    ): self;

    /**
     * Adds a FULL OUTER JOIN clause to the query.
     *
     * Joins another table or subquery using FULL OUTER JOIN, returning all rows from both tables,
     * with NULLs where no match exists. Note: Not supported by MySQL, mainly for PostgreSQL.
     *
     * When using a subquery, an alias is required and will be enforced by the implementation.
     *
     * Examples:
     * - Table: fullJoin('orders', 'orders.user_id = users.id', 'o')
     * - Subquery: fullJoin($subquery, 'subq.id = users.id', 'subq')
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to join
     * @param string $constraint The join condition (e.g., 'orders.user_id = users.id')
     * @param string|null $alias Optional alias for the joined table (required for subqueries)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function fullJoin(
        string|DbQueryBuilderInterface $container,
        string $constraint,
        ?string $alias = null
    ): self;

    /**
     * Adds a CROSS JOIN clause to the query.
     *
     * Performs a Cartesian product, combining every row from the first table
     * with every row from the second table. No join condition is required.
     *
     * When using a subquery, an alias is required and will be enforced by the implementation.
     *
     * Examples:
     * - Table: crossJoin('orders', 'o')
     * - Subquery: crossJoin($subquery, 'subq')
     *
     * @param string|DbQueryBuilderInterface $container The table name or subquery to cross join
     * @param string|null $alias Optional alias for the joined table (required for subqueries)
     * @return self Returns the query builder instance for method chaining
     * @throws InvalidArgumentException If $container is a subquery and $alias is null (enforced in implementation)
     */
    public function crossJoin(string|DbQueryBuilderInterface $container, ?string $alias = null): self;

    /**
     * Combines this query with another using UNION.
     *
     * Merges the results of two queries, removing duplicate rows.
     * Both queries must have the same number and compatible types of columns.
     *
     * @param DbQueryBuilderInterface $query The query to union with this query
     * @return self Returns the query builder instance for method chaining
     */
    public function union(DbQueryBuilderInterface $query): self;

    /**
     * Combines this query with another using UNION ALL.
     *
     * Merges the results of two queries, keeping all rows including duplicates.
     * Both queries must have the same number and compatible types of columns.
     *
     * @param DbQueryBuilderInterface $query The query to union with this query
     * @return self Returns the query builder instance for method chaining
     */
    public function unionAll(DbQueryBuilderInterface $query): self;

    /**
     * Specifies columns for the GROUP BY clause.
     *
     * Groups result rows by one or more columns. Typically used with aggregate
     * functions like COUNT, SUM, AVG. Multiple columns can be passed as variadic arguments.
     *
     * @param string ...$columns One or more column names to group by
     * @return self Returns the query builder instance for method chaining
     */
    public function groupBy(string ...$columns): self;

    /**
     * Adds a HAVING clause for filtering grouped results.
     *
     * Filters groups created by GROUP BY based on aggregate conditions.
     * Similar to WHERE but operates on grouped data. Returns a condition builder
     * for specifying the comparison.
     *
     * @param string $expression The aggregate expression or column to filter (e.g., 'COUNT(*)')
     * @param string|null $openBracket Optional opening bracket(s) for grouping conditions
     * @return DbQueryConditionBuilderInterface Returns the condition builder for defining comparisons
     */
    public function having(string $expression, ?string $openBracket = null): DbQueryConditionBuilderInterface;

    /**
     * Specifies the column and direction for sorting results.
     *
     * Defines the ORDER BY clause for sorting query results. Can be called
     * multiple times to sort by multiple columns in sequence.
     *
     * @param string $column The column name to sort by
     * @param string $direction The sort direction: 'ASC' (ascending) or 'DESC' (descending), default is 'ASC'
     * @return self Returns the query builder instance for method chaining
     */
    public function orderBy(string $column, string $direction = 'ASC'): self;

    /**
     * Limits the number of rows returned and optionally sets an offset.
     *
     * Adds LIMIT and OFFSET clauses for pagination or restricting result size.
     * Both parameters are optional to allow flexible usage.
     *
     * @param int|null $limit Maximum number of rows to return (null for no limit)
     * @param int|null $offset Number of rows to skip before starting to return rows (null for no offset)
     * @return self Returns the query builder instance for method chaining
     */
    public function limit(?int $limit = null, ?int $offset = null): self;

    /**
     * Generates an SQL query based on the specified dialect and preparation mode.
     *
     * Creates an SQL query string or a prepared query object, depending on the options provided.
     *
     * @param string $dialect The SQL dialect to use (e.g., 'mysql', 'pgsql', 'sqlite')
     * @param bool $prepared Set to true if a prepared query should be returned, false for a raw SQL string
     * @return string|DbPreparedQueryInterface Returns the raw SQL string or a prepared query object
     * @throws InvalidArgumentException If an unsupported dialect is provided (enforced in implementation)
     */
    public function sql(string $dialect, bool $prepared = true): string|DbPreparedQueryInterface;
}
