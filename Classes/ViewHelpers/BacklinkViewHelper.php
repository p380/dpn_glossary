<?php
namespace Featdd\DpnGlossary\ViewHelpers;

/***
 *
 * This file is part of the "dreipunktnull Glossar" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Daniel Dorndorf <dorndorf@featdd.de>
 *
 ***/

use Featdd\DpnGlossary\Hook\RenderPreProcessHook;
use Featdd\DpnGlossary\Service\LinkService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * @package DpnGlossary
 * @subpackage ViewHelpers
 */
class BacklinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * @var array
     */
    protected $settings = array();

    /**
     * @var \Featdd\DpnGlossary\Service\LinkService
     */
    protected $linkService;

    /**
     * @param \Featdd\DpnGlossary\Service\LinkService $linkService
     */
    public function injectLinkService(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function initialize()
    {
        parent::initialize();

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManager::class);

        $this->settings = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, 'dpnglossary');
    }

    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerArgument('absolute', 'bool', 'Should the link be absolute', false, false);
    }

    /**
     * @return string
     */
    public function render()
    {
        if (true === (bool) $this->settings['useHttpReferer']) {
            $httpReferer = GeneralUtility::getIndpEnv('HTTP_REFERER');

            $url = false === empty($httpReferer)
                ? $httpReferer
                : $this->getLink();
        } else {
            $getParams = GeneralUtility::_GET(RenderPreProcessHook::URL_PARAM_DETAIL);

            $url = true === array_key_exists('pageUid', $getParams)
                ? $this->getLink($getParams['pageUid'])
                : $this->getLink();
        }

        $this->tag->addAttribute('href', $url);

        $this->tag->setContent(
            $this->renderChildren()
        );

        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }

    /**
     * @param int $pageUid
     * @return string
     */
    protected function getLink($pageUid = null)
    {
        $pageUid = null === $pageUid
            ? $this->settings['listPage']
            : $pageUid;

        return $this->linkService->buildLink(
            $pageUid,
            array(),
            (bool) $this->arguments['absolute'],
            $GLOBALS['TSFE']->sys_language_uid
        );
    }
}
