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
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayProductExtraContent');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    public function hookDisplayProductExtraContent()
    {
        /* Place your code here. */
    }
}
