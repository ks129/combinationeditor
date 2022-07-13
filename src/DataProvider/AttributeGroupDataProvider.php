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

namespace PrestaShop\Module\CombinationEditor\DataProvider;

use AttributeGroup;

/**
 * This class provides data from DB / ORM about Attribute Groups.
 */
class AttributeGroupDataProvider
{
    /**
     * @param int $id_lang
     */
    public function getAttributeGroups(int $langId): array
    {
        //return AttributeGroup::getAttributesGroups($langId);
        return [];
    }
}
