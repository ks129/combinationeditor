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

use PrestaShop\Module\CombinationEditor\Query\GetCombinationAttributes;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Combinationeditor extends Module
{
    public function __construct()
    {
        $this->name = 'combinationeditor';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Karlis Suvi';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->trans('Combination Attributes Editor', [], 'Modules.Combinationeditor.Admin');
        $this->description = $this->trans('Change combination\'s attributes even after creation.', [], 'Modules.Combinationeditor.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall this module?', [], 'Modules.Combinationeditor.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->registerHook('displayAdminProductsCombinationBottom');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookActionAdminControllerSetMedia()
    {
        if (!$this->isSymfonyContext()) {
            return;
        }

        $requestStack = $this->get('request_stack');
        $currentRequest = $requestStack->getCurrentRequest();

        if (null === $currentRequest || 'admin_product_form' !== $currentRequest->get('_route')) {
            return;
        }

        $this->context->controller->addJS(
            "{$this->getPathUri()}views/js/combinationeditor.js"
        );
    }

    /**
     * Displays attributes form under combination settings.
     * 
     * @param array $params
     */
    public function hookDisplayAdminProductsCombinationBottom($params)
    {
        $formBuilder = $this->get('prestashop.module.combinationeditor.form.identifiable_object.builder.combination_attributes_form_builder');
        $form = $formBuilder->getFormFor((int) $params['id_product_attribute']);

        return $this->get('twig')->render(
            '@Modules/combinationeditor/views/templates/admin/attributes_manager.html.twig',
            [
                'attributesForm' => $form->createView(),
            ]
        );
    }
}
