<?php

namespace Sef\Controller;

use DI\Container;

/**
 * Interface ControllerInterface
 *
 * Can be used by the module-controllers so they can get DIC in case the programmer will want to get instances
 * by accessing the DIC directly
 *
 * @package Sef\Controller
 */
interface ControllerInterface
{
    public function setDic(Container $dic);
}
