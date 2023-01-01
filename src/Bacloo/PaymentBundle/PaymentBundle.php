<?php

namespace Bacloo\PaymentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
class PaymentBundle extends Bundle
{
	/**
	* {@inheritDoc}
	*/
	public function getParent()
	{
		return 'PayumBundle';
	}
}
