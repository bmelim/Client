<?php

declare(strict_types=1);

/*
 * This file is part of the DigitalOceanV2 library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DigitalOceanV2\Entity;

/**
 * @author Yassir Hannoun <yassir.hannoun@gmail.com>
 * @author Graham Campbell <graham@alt-three.com>
 */
final class FirewallRuleOutbound extends FirewallRule
{
    /**
     * @var FirewallLocations
     */
    public $destinations;

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function build(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            switch ($property) {
                case 'destinations':
                    if (\is_object($value)) {
                        $this->destinations = new FirewallLocations($value);
                    }
                    unset($parameters[$property]);

                    break;
            }
        }

        parent::build($parameters);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['destinations'] = $this->destinations->toArray();

        return $data;
    }
}
