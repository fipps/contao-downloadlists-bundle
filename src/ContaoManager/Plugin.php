<?php
/**
 * Contao DownloadlistsBundle Bundle
 *
 * @copyright 2018 agentur fipps e.K.
 * @author    Arne Borchert
 * @package   fipps\contao-downloadlists-bundle
 * @license   LGPL 3.0+
 */

namespace Fipps\DownloadlistsBundle\ContaoManager;

use Fipps\DownloadlistsBundle\FippsDownloadlistsBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 *
 * @author Aren Borchert
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(FippsDownloadlistsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['fipps_downloadlists'])
        ];
    }
}