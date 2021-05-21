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
class TtContent
{
    /**
     * Gets gridelements backend layout value
     *
     * @param int $uid
     */
    public static function getParentGridelementsBackendLayout($uid)
    {
        $backendLayout = '';
        /** @var ConnectionPool $databaseConnection */
        $databaseConnection = Database::getConnectionPool('tt_content');
        $currentRecord = $databaseConnection->select(
            ['tx_gridelements_container'],
            'tt_content',
            ['uid' => (int)$uid]
        )->fetch();

        if (isset($currentRecord['tx_gridelements_container']) && !empty($currentRecord['tx_gridelements_container'])) {
            $parentRecord = $databaseConnection->select(
                ['tx_gridelements_backend_layout'],
                'tt_content',
                ['uid' => (int)$currentRecord['tx_gridelements_container']]
            )->fetch();
            $backendLayout = $parentRecord['tx_gridelements_backend_layout'];
        }

        return $backendLayout;
    }
}
