<?php

namespace EduardoAf\Components;

use EduardoAf\Components\Exceptions\ComponentException;

final class QueryWriteBuilder
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getUpdateQuery(array $set, array $where=[], string $comment=""): string
    {
        if (!isset($set["table"]))
            ComponentException::unexpectedErrorOnRequest(__METHOD__." missing table name");

        $query = [
        "
        -- {$comment}
        UPDATE `{$set["table"]}` 
        SET 
        "
        ];
        unset($set["table"]);

        $fieldsAndValues = [];
        foreach ($set as $column => $value) {
            $fieldsAndValues[] = "`{$column}` = '{$value}'";
        }

        $query[] = implode(", ", $fieldsAndValues);
        $query[] = "WHERE 1";

        foreach ($where as $column => $value) {
            $query[] = "AND `{$column}` = '{$value}'";
        }
        return implode(" ", $query);
    }

    public function getInsertQuery(array $insert, string $comment = ""): string
    {
        if (!isset($insert["table"]))
            ComponentException::unexpectedErrorOnRequest(__METHOD__ . " missing table name");

        $table = $insert["table"];
        unset($insert["table"]);

        if (empty($insert))
            ComponentException::unexpectedErrorOnRequest(__METHOD__ . " no data to insert");

        $columns = array_map(fn($col) => "`{$col}`", array_keys($insert));
        $values = array_map(fn($val) => "'{$val}'", array_values($insert));

        $query = [
            "-- {$comment}\n",
            "INSERT INTO `{$table}` (" . implode(", ", $columns) . ")",
            "VALUES (" . implode(", ", $values) . ")"
        ];

        return implode(" ", $query);
    }

}
