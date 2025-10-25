<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

interface DbQueryExistsInterface
{
    /**
     * Generates an EXISTS conditional clause for a query.
     *
     * @param DbQueryBuilderInterface $query The subquery to be evaluated within the EXISTS clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function exists(
        DbQueryBuilderInterface $query,
        ?string $closeBracket = null
    ): DbQueryBuilderInterface;

    /**
     * Generates a NOT EXISTS conditional clause for a query.
     *
     * @param DbQueryBuilderInterface $query The subquery to be used in the NOT EXISTS clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function notExists(
        DbQueryBuilderInterface $query,
        ?string $closeBracket = null
    ): DbQueryBuilderInterface;
}
