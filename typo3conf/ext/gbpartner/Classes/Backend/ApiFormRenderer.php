<?php
namespace Gigabonus\Gbpartner\Backend\Tca;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\DebugUtility;

class ApiFormRenderer {
    public function render($PA, $fObj) {

        /**
         * @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer
         */
        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addJsFile('/typo3conf/ext/gbbase/Resources/Public/Scripts/Backend/Tca.js');

        $id = htmlspecialchars($PA['itemFormElID']);
        $formField  = '<div style="width:400px">';
        $formField .= '<input type="text" name="' . $PA['itemFormElName'] . '"';

        $formField .= ' data-formengine-validation-rules="[{&quot;type&quot;:&quot;trim&quot;,&quot;config&quot;:{&quot;type&quot;:&quot;input&quot;,&quot;size&quot;:20}},{&quot;type&quot;:&quot;required&quot;,&quot;config&quot;:{&quot;type&quot;:&quot;input&quot;,&quot;size&quot;:20}}]"';


        $formField .= ' value="' . htmlspecialchars($PA['itemFormElValue']) . '"';
        $formField .= ' id="' . $id . '"  class="form-control t3js-clearable" >';

        $formField .= '<br>';
        $formField .= '<input type="button" value="Generate API key" onclick="generateApiKey(\'' . $id . '\')">';
        $formField .= '</div>';

        return $formField;
    }
}
