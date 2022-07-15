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

namespace PrestaShop\Module\CombinationEditor\Controller;

use Exception;
use PrestaShop\Module\CombinationEditor\Command\SetCombinationAttributesCommand;
use PrestaShop\Module\CombinationEditor\Exception\CombinationNotFoundException;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CombinationEditorController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('update', 'AdminProducts')", message="You do not have permission edit products.")
     * 
     * Returns list of given attribute group attributes for dropdown.
     */
    public function getAttributesAction(Request $request, int $attributeGroupId): JsonResponse
    {
        $attributeDataProvider = $this->get('prestashop.module.combinationeditor.data_provider.attribute_data_provider');
        $choices = [];
        $langId = $this->get('prestashop.adapter.legacy.context')->getLanguage()->id;

        foreach ($attributeDataProvider->getAttributes($attributeGroupId, (int) $langId) as $attribute) {
            $choices[$attribute['name']] = (int) $attribute['id_attribute'];
        }

        return new JsonResponse($choices);
    }

    /**
     * @AdminSecurity("is_granted('update', 'AdminProducts')", message="You do not have permission edit products.")
     * 
     * Saves combination's attributes.
     */
    public function saveAttributesAction(Request $request, int $combinationId): JsonResponse
    {
        $formBuilder = $this->get('prestashop.module.combinationeditor.form.identifiable_object.builder.combination_attributes_form_builder');
        $form = $formBuilder->getFormFor($combinationId);
        $form->handleRequest($request);

        $data = $form->getData();
        $attributeIds = [];

        foreach ($data['attributes'] as $attribute) {
            $attributeIds[] = (int) $attribute['attribute'];
        }

        // Combinations must have at least one attribute
        if (count($attributeIds) < 1) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $this->trans('Combination must have at least one attribute.', 'Modules.Combinationeditor.Error')
                ]
            );
        }

        // Do not allow duplicates
        if (count($attributeIds) > count(array_unique($attributeIds))) {
            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $this->trans('Duplicate attributes are not allowed.', 'Modules.Combinationeditor.Error'),
                ]
            );
        }

        // Update attributes
        try {
            $this->getCommandBus()->handle(
                (new SetCombinationAttributesCommand($combinationId))->setAttributeIds($attributeIds)
            );
        } catch (Exception $e) {
            if ($e instanceof CombinationNotFoundException) {
                $message = $this->trans('Combination not found.', 'Modules.Combinationeditor.Error');
            } else {
                $message = $e->getMessage();
            }

            return new JsonResponse(
                [
                    'success' => false,
                    'message' => $message,
                ]
            );
        }

        // Receive new name for replacement
        $nameProvider = $this->get('prestashop.module.combinationeditor.service.combination_name_provider');
        $langId = $this->get('prestashop.adapter.legacy.context')->getLanguage()->id;

        $name = $nameProvider->getName($combinationId, $langId);

        return new JsonResponse([
            'success' => true,
            'name' => $name,
            'title' => $this->trans('Combination details', 'Admin.Catalog.Feature') . ' - ' . $name,
        ]);
    }
}
