<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 */

declare(strict_types=1);

namespace CoreShop\Bundle\PimcoreBundle\DependencyInjection;

use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterGridActionPass;
use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler\RegisterGridFilterPass;
use CoreShop\Bundle\PimcoreBundle\DependencyInjection\Extension\AbstractPimcoreExtension;
use CoreShop\Component\Pimcore\DataObject\Grid\GridActionInterface;
use CoreShop\Component\Pimcore\DataObject\Grid\GridFilterInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class CoreShopPimcoreExtension extends AbstractPimcoreExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configs = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $bundles = $container->getParameter('kernel.bundles');

        if (array_key_exists('PimcoreDataHubBundle', $bundles)) {
            $loader->load('services/data_hub.yml');
        }

        $this->registerPimcoreResources('coreshop', $configs['pimcore_admin'], $container);

        $loader->load('services.yml');

        $container
            ->registerForAutoconfiguration(GridActionInterface::class)
            ->addTag(RegisterGridActionPass::GRID_ACTION_TAG);

        $container
            ->registerForAutoconfiguration(GridFilterInterface::class)
            ->addTag(RegisterGridFilterPass::GRID_FILTER_TAG);
    }
}
