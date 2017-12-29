<?php
namespace SJBR\SrFreecap\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2017 Stanislas Rolland <typo3(arobas)sjbr.ca>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use SJBR\SrFreecap\ViewHelpers\TranslateViewHelper;
use TYPO3\CMS\Core\Session\Backend\Exception\SessionNotFoundException;
use TYPO3\CMS\Core\Utility\ClientUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class AudioViewHelper extends AbstractTagBasedViewHelper
{
	/**
	 * @var string Name of the extension this view helper belongs to
	 */
	protected $extensionName = 'SrFreecap';

	/**
	 * @var string Name of the extension this view helper belongs to
	 */
	protected $pluginName = 'tx_srfreecap';

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
	{
		$this->configurationManager = $configurationManager;
	}

	/**
	 * Render the captcha audio rendering request icon
	 *
	 * @param string suffix to be appended to the extenstion key when forming css class names
	 * @return string The html used to render the captcha audio rendering request icon
	 */
	public function render($suffix = '')
	{
		// This viewhelper needs a frontend user session
		if (!is_object($GLOBALS ['TSFE']) || !isset($GLOBALS ['TSFE']->fe_user)) {
			throw new SessionNotFoundException('No frontend user found in session!');
		}

		$value = '';
		// Get the plugin configuration
		$settings = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, $this->extensionName, $this->pluginName);
		// Get the translation view helper
		$translator = GeneralUtility::makeInstance(TranslateViewHelper::class);
		$translator->injectConfigurationManager($this->configurationManager);
		// Get browser info: in IE 8, we will use a simple link, as dynamic insertion of object element gives unpredictable results
        $browserInfo = ClientUtility::getBrowserInfo(GeneralUtility::getIndpEnv('HTTP_USER_AGENT'));
        $browerIsIE8 = $browserInfo['browser'] == 'msie' && $browserInfo['version'] == '8';
		// Generate the icon
		if ($settings['accessibleOutput'] && (int)$GLOBALS['TYPO3_CONF_VARS']['SYS']['UTF8filesystem']) {
			$fakeId = GeneralUtility::shortMD5(uniqid (rand()),5);
			$siteURL = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
			$urlParams = array(
				'eID' => 'sr_freecap_EidDispatcher',
				'id' => $GLOBALS['TSFE']->id,
				'vendorName' => 'SJBR',
				'extensionName' => $this->extensionName,
				'pluginName' => 'AudioPlayer',
				'controllerName' => 'AudioPlayer',
				'actionName' => 'play',
				'formatName' => $browerIsIE8 ? 'mp3' : 'wav',
			);
			$L = GeneralUtility::_GP('L');
			if (isset($L)) {
				$urlParams['L'] = htmlspecialchars($L);
			}
			if ($GLOBALS['TSFE']->MP) {
				$urlParams['MP'] = $GLOBALS['TSFE']->MP;
			}
			$audioURL = $siteURL . 'index.php?' . ltrim(GeneralUtility::implodeArrayForUrl('', $urlParams), '&');
			if ($settings['accessibleOutputImage']) {
				if ($browerIsIE8) {
					$value = '<a href="' . $audioURL . '&set=' . rand()
						. '" title="' . $translator->render('click_here_accessible') . '">'
						. '<img alt="' . $translator->render('click_here_accessible') . '"'
						. ' src="' . $siteURL . str_replace(PATH_site, '', GeneralUtility::getFileAbsFileName($settings['accessibleOutputImage'])) . '"'
						. $this->getClassAttribute('image-accessible', $suffix) . ' />'
						. '</a>';
				} else {
					$value = '<input type="image" alt="' . $translator->render('click_here_accessible') . '"'
						. ' title="' . $translator->render('click_here_accessible') . '"'
						. ' src="' . $siteURL . str_replace(PATH_site, '', GeneralUtility::getFileAbsFileName($settings['accessibleOutputImage'])) . '"'
						. ' onclick="' . $this->extensionName . '.playCaptcha(\'' . $fakeId . '\', \'' . $audioURL . '\', \'' . $translator->render('noPlayMessage') . '\');return false;" style="cursor: pointer;"'
						. $this->getClassAttribute('image-accessible', $suffix) . ' />';
				}
			} else {
				if ($browerIsIE8) {
					$value = '<span id="tx_srfreecap_captcha_playLink_' . $fakeId . '"'
						. $this->getClassAttribute('accessible-link', $suffix) . '>'
						. $translator->render('click_here_accessible_before_link')
						. '<a href="' . $audioURL . '&set=' . rand() . '"'
						. ' title="' . $translator->render('click_here_accessible') . '">'
						. $translator->render('click_here_accessible_link')
						. '</a>'
						. $translator->render('click_here_accessible_after_link') . '</span>';
				} else {
					$value = '<span id="tx_srfreecap_captcha_playLink_' . $fakeId . '"'
						. $this->getClassAttribute('accessible-link', $suffix) . '>' . $translator->render('click_here_accessible_before_link')
						. '<a onClick="' . $this->extensionName . '.playCaptcha(\'' . $fakeId.'\', \'' . $audioURL . '\', \'' . $translator->render('noPlayMessage') . '\');" style="cursor: pointer;" title="' . $translator->render('click_here_accessible') . '">'
						. $translator->render('click_here_accessible_link') . '</a>'
						. $translator->render('click_here_accessible_after_link') . '</span>';
				}
			}
			$value .= '<span' . $this->getClassAttribute('accessible', $suffix) . ' id="tx_srfreecap_captcha_playAudio_' . $fakeId . '"></span>';
		}
		return $value;
	}

	/**
	 * Returns a class attribute with a class-name prefixed with $this->pluginName and with all underscores substituted to dashes (-)
	 *
	 * @param string $class The class name (or the END of it since it will be prefixed by $this->pluginName.'-')
	 * @param string suffix to be appended to the extenstion key when forming css class names
	 * @return string the class attribute with the combined class name (with the correct prefix)
	 */
	protected function getClassAttribute ($class, $suffix = '')
	{
		return ' class="' . trim(str_replace('_', '-', $this->pluginName) . ($suffix ? '-' . $suffix . '-' : '-') . $class) . '"';
	}
}