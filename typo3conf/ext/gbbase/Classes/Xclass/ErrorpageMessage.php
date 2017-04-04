<?php
namespace Gigabonus\Gbbase\Xclass;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * A class representing error messages shown on a page.
 * Classic Example: "No pages are found on rootlevel"
 *
 * @author Benjamin Mack <benni@typo3.org>
 */
class ErrorpageMessage extends \TYPO3\CMS\Core\Messaging\ErrorpageMessage {

    /**
     * Renders the message.
     *
     * @return string The message as HTML.
     */
    public function render() {
        # $markers = array_merge($this->getDefaultMarkers(), $this->markers);
        # $content = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl('maintenance/errorpage-message.html');
        # $content = \TYPO3\CMS\Core\Html\HtmlParser::substituteMarkerArray($content, $markers, '', FALSE, TRUE);
        $content = "<h1>Eigener Content der Error-Seite</h1><p>Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später nochmal. Entschuldigen Sie die Unannehmlichkeiten.<br>
                    SetEnv TYPO3_CONTEXT Development<br>
                    Debug Settings: Live
                   </p>";
        return $content;
    }

}
