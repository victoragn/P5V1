<?php

namespace Agnez\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AgnezUserBundle extends Bundle
{
    public function getParent()
  {
    return 'FOSUserBundle';
  }
}
