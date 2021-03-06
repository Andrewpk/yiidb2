<?php

/**
 * CIbmDB2CommandBuilder class file.
 *
 * @author Edgard L. Messias <edgardmessias@gmail.com>
 * @link https://github.com/edgardmessias/yiidb2
 */

/**
 * CIbmDB2CommandBuilder provides basic methods to create query commands for tables for IBM DB2 Servers.
 *
 * @author Edgard L. Messias <edgardmessias@gmail.com>
 * @package ext.yiidb2
 */
class CIbmDB2CommandBuilder extends CDbCommandBuilder {

    /**
     * Alters the SQL to apply LIMIT and OFFSET.
     * Default implementation is applicable for PostgreSQL, MySQL and SQLite.
     * @param string $sql SQL query string without LIMIT and OFFSET.
     * @param integer $limit maximum number of rows, -1 to ignore limit.
     * @param integer $offset row offset, -1 to ignore offset.
     * @return string SQL with LIMIT and OFFSET
     */
    public function applyLimit($sql, $limit, $offset) {
        $limit = $limit !== null ? (int) $limit : 0;
        $offset = $offset !== null ? (int) $offset : 0;

        if ($limit > 0 && $offset <= 0) {
            $sql.=' FETCH FIRST ' . $limit . ' ROWS ONLY';
        } elseif ($offset > 0) {
            $query = 'SELECT dbnumberedrows.* FROM (SELECT ROW_NUMBER() OVER() AS dbrownumber, dbresult.* FROM (' . $sql . ') AS dbresult) AS dbnumberedrows';
            if ($limit == 1) {
                $query .= ' WHERE (dbnumberedrows.dbrownumber = ' . ($offset + 1) . ')';
            } elseif ($limit > 0) {
                $query .= ' WHERE (dbnumberedrows.dbrownumber BETWEEN ' . ($offset + 1) . ' AND ' . ($offset + $limit) . ')';
            } else {
                $query .= ' WHERE (dbnumberedrows.dbrownumber > ' . ($offset + 1) . ')';
            }
            return $query;
        }
        return $sql;
    }

}
