<?php
/**
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
*
*  @author    Karlis Suvi
*  @copyright 2022 Karlis Suvi
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

declare(strict_types=1);

namespace PrestaShop\Module\CombinationEditor\Service;

use Db;

/**
 * Service for generating combination name.
 */
class CombinationNameProvider
{
    /**
     * Provides combination name.
     *
     * @param int $combinationId
     * @param int $langId
     *
     * @return string
     */
    public function getName(int $combinationId, int $langId): string
    {
        $attributes = Db::getInstance()->executeS('
            SELECT al.name AS attribute_name, agl.name AS attribute_group_name
            FROM `' . _DB_PREFIX_ . 'product_attribute_combination` pac
            LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON (pac.`id_attribute` = a.`id_attribute`)
            LEFT JOIN `' . _DB_PREFIX_ . 'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = ' . $langId . ')
            LEFT JOIN `' . _DB_PREFIX_ . 'attribute_group_lang` agl ON (a.`id_attribute_group` = agl.`id_attribute_group` AND agl.`id_lang` = ' . $langId . ')
            WHERE pac.`id_product_attribute` = ' . $combinationId . ';
        ');

        $pairs = [];
        foreach ($attributes as $attribute) {
            $pairs[] = sprintf('%s - %s', $attribute['attribute_group_name'], $attribute['attribute_name']);
        }

        return implode(', ', $pairs);
    }
}
