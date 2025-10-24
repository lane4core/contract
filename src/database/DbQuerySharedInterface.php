<?php

declare(strict_types=1);

namespace Lane4core\Contract\Database;

interface DbQuerySharedInterface
{
    /**
     * Generates an EXISTS conditional clause for a query.
     *
     * @param DbQueryBuilderInterface $query The subquery to be evaluated within the EXISTS clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if the optional flag is false.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function exists(
        DbQueryBuilderInterface $query,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;

    /**
     * Generates a NOT EXISTS conditional clause for a query.
     *
     * @param DbQueryBuilderInterface $query The subquery to be used in the NOT EXISTS clause.
     * @param ?string $closeBracket An optional closing bracket appended to the condition.
     * @param bool $optional If true, the condition will only be added if it is mandatory.
     * @return DbQueryBuilderInterface The current query builder instance with the new condition applied.
     */
    public function notExists(
        DbQueryBuilderInterface $query,
        ?string $closeBracket = null,
        bool $optional = false
    ): DbQueryBuilderInterface;
}
