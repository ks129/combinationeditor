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

namespace PrestaShop\Module\CombinationEditor\QueryHandler;

use Combination;
use Db;
use PrestaShop\Module\CombinationEditor\Exception\CannotGetCombinationAttributesException;
use PrestaShop\Module\CombinationEditor\Exception\CombinationNotFoundException;
use PrestaShop\Module\CombinationEditor\Query\GetCombinationAttributes;
use PrestaShop\Module\CombinationEditor\QueryResult\CombinationAttribute;
use PrestaShop\Module\CombinationEditor\QueryResult\CombinationAttributes;
use PrestaShopException;

/**
 * Handles command that gets combination's attributes for editing.
 */
class GetCombinationAttributesHandler
{
    /**
     * @param GetCombinationAttributes $query
     *
     * @return CombinationAttributes
     */
    public function handle(GetCombinationAttributes $query): CombinationAttributes
    {
        // First ensure that combination actually exists.
        $combinationId = $query->getCombinationId()->getValue();

        try {
            $combination = new Combination($combinationId);

            if ((int) $combination->id !== $combinationId) {
                throw new CombinationNotFoundException(sprintf('Cannot find combination with ID %d', $combinationId));
            }
        } catch (PrestaShopException $e) {
            throw new CannotGetCombinationAttributesException(sprintf('An error occurred when receiving combination with ID %d', $combinationId));
        }

        // Now create query for getting all necessary data.
        $data = Db::getInstance()->executeS('
            SELECT pac.`id_attribute`, a.`id_attribute_group`
            FROM `' . _DB_PREFIX_ . 'product_attribute_combination` pac
            LEFT JOIN `' . _DB_PREFIX_ . 'attribute` a ON (pac.`id_attribute` = a.`id_attribute`)
            WHERE pac.`id_product_attribute` = ' . $combinationId . ';
        ');

        $attributes = [];
        foreach ($data as $attr) {
            $attributes[(int) $attr['id_attribute_group']][] = (int) $attr['id_attribute'];
        }

        $combinationAttributes = [];

        foreach ($attributes as $attributeGroupId => $attributeIds) {
            $combinationAttributes[] = new CombinationAttribute(
                $attributeIds,
                (int) $attributeGroupId
            );
        }

        return new CombinationAttributes($combinationAttributes);
    }
}
