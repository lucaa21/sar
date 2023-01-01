<?php

namespace Bacloo\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BaclooUserBundle extends Bundle
{
    public function getParent()
    {
      return 'FOSUserBundle';
    }
}
