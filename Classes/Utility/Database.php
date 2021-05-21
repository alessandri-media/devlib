<?php

namespace AlessandriMedia\Devlib\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 René Alessandri <rene@alessandri-media.ch>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Database
{

    /**
     * @param $table
     * @param array $data
     */
    public static function insert($table, array $data)
    {
        $queryBuilder = self::getQueryBuilder($table);
        $queryBuilder->insert($table)->values($data)->execute();
    }

    /**
     * @param $table
     * @param array $data
     * @param array $where
     */
    public static function update($table, array $data, array $where)
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = self::getConnectionPool($table);
        $databaseConnection->update(
            $table,
            $data,
            $where
        );
    }

    /**
     * @param $table
     * @param array $data
     * @param array $columnNames
     */
    public static function bulkInsert($table, array $data, array $columnNames)
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = self::getConnectionPool($table);
        $databaseConnection->bulkInsert(
            $table,
            $data,
            $columnNames
        );
    }

    /**
     * @param $table
     * @param array $where
     */
    public static function delete($table, array $where)
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = self::getConnectionPool($table);
        $databaseConnection->delete(
            $table,
            $where
        );
    }

    /**
     * @param $table
     */
    public static function truncate($table)
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = self::getConnectionPool($table);
        $databaseConnection->truncate($table);
    }

    /**
     * @param $table
     * @return QueryBuilder
     */
    public static function getQueryBuilder($table)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        return $queryBuilder;
    }

    /**
     * @param $table
     * @return Connection
     */
    public static function getConnectionPool($table)
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table);
        return $databaseConnection;
    }

    /**
     * @param string $table
     * @param string $autoincrementField
     * @return int
     */
    public static function getLastInsertId($table, $autoincrementField = 'uid')
    {
        /** @var Connection $databaseConnection */
        $databaseConnection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($table);
        return (int)$databaseConnection->lastInsertId($table, $autoincrementField);
    }
}
