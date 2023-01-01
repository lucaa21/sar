<?php
namespace Payum\Bundle\PayumBundle\Tests\Functional\Form\Type;

use Payum\Bundle\PayumBundle\Tests\Functional\WebTestCase;
use Symfony\Component\Form\FormFactoryInterface;

class GatewayConfigTypeTest extends WebTestCase
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    protected function setUp()
    {
        parent::setUp();

        $this->formFactory = $this->container->get('form.factory');
    }

    /**
     * @test
     */
    public function couldBeCreatedByFormFactory()
    {
        $form = $this->formFactory->create('payum_gateway_config', null, array(
            'data_class' => 'Payum\Core\Model\GatewayConfig',
        ));
        $view = $form->createView();

        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form);
        $this->assertInstanceOf('Symfony\Component\Form\FormView', $view);
    }
}