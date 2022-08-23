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

namespace CoreShop\Bundle\PimcoreBundle\DependencyInjection\Compiler;

use CoreShop\Component\Registry\RegisterSimpleRegistryTypePass;

class RegisterGridFilterPass extends RegisterSimpleRegistryTypePass
{
    public const GRID_FILTER_TAG = 'coreshop.grid.filter';

    public function __construct()
    {
        parent::__construct(
            'coreshop.registry.grid.filter',
            'coreshop.grid.filters',
            self::GRID_FILTER_TAG
        );
    }
}
