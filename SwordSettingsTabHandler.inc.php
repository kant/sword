<?php

/**
 * @file plugins/generic/sword/SwordSettingsTabHandler.inc.php
 *
 * Copyright (c) 2003-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SwordSettingsTabHandler
 * @ingroup plugins_generic_sword
 *
 * @brief Responds to requests for SWORD settings page
 */

import('classes.handler.Handler');

class SwordSettingsTabHandler extends Handler {
	/** @var SwordPlugin Reference to SWORD plugin */
	protected $_plugin = null;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		
		$this->_plugin = PluginRegistry::getPlugin('generic', 'swordplugin');
		
		$this->addRoleAssignment(
			array(ROLE_ID_MANAGER),
			array('swordSettings')
		);
	}
	
	
	public function swordSettings($args, $request) {
		$context = $request->getContext();
		AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON,  LOCALE_COMPONENT_PKP_MANAGER);
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->register_function('plugin_url', array($this, 'smartyPluginUrl'));
		
		$this->_plugin->import('SwordSettingsForm');
		$form = new SwordSettingsForm($this->_plugin, $context);
		if ($request->getUserVar('save')) {
		} else {
			$form->initData();
		}
		
		return new JSONMessage(true, $form->fetch($request));
	}
}