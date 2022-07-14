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

namespace PrestaShop\Module\CombinationEditor\CommandHandler;

use Combination;
use PrestaShop\Module\CombinationEditor\Command\SetCombinationAttributesCommand;
use PrestaShop\Module\CombinationEditor\Exception\CannotSetCombinationAttributesException;
use PrestaShopException;

/**
 * Handles command that sets combination's attributes
 */
class SetCombinationAttributesCommandHandler
{
    /**
     * @param SetCombinationAttributesCommand $command
     */
    public function handle(SetCombinationAttributesCommand $command): void
    {
        $combinationId = $command->getCombinationId()->getValue();
        
        try {
            $combination = new Combination($combinationId);

            if ($combination->id != $combinationId) {
                throw new CannotSetCombinationAttributesException(
                    sprintf('Cannot find combination with ID %d', $combinationId),
                    CannotSetCombinationAttributesException::COMBINATION_NOT_FOUND
                );
            }
        } catch (PrestaShopException $e) {
            throw new CannotSetCombinationAttributesException(sprintf('Error occurred when receiving combination with ID %d', $combinationId));
        }

        $attributeIds = [];
        foreach ($command->getAttributeIds() as $attributeIdObj) {
            $attributeIds[] = $attributeIdObj->getValue();
        }

        try {
            $combination->setAttributes($attributeIds);
        } catch (PrestaShopException $e) {
            throw new CannotSetCombinationAttributesException(
                sprinf('Error occurred when setting attributes for combination with ID %d', (int) $combination->id),
                CannotSetCombinationAttributesException::CANNOT_SET_ATTRIBUTES
            );
        }
    }
}
