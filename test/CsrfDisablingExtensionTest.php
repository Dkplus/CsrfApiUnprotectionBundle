<?php
namespace DkplusTest\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\CsrfDisablingExtension;
use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UnprotectionRule;
use PHPUnit_Framework_TestCase as TestCase;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\CsrfDisablingExtension
 */
class CsrfDisablingExtensionTest extends TestCase
{
    public function testItShouldExtendFormsAsAHole()
    {
        $extension = new CsrfDisablingExtension(
            $this->prophesize(RequestStack::class)->reveal(),
            $this->prophesize(UnprotectionRule::class)->reveal()
        );
        $this->assertSame('form', $extension->getExtendedType());
    }

    public function testItShouldNotModifyFormsWhenTheGivenRulesDoesNotMatchTheRequest()
    {
        $request  = $this->prophesize(Request::class);
        $requests = $this->prophesize(RequestStack::class);
        $requests->getMasterRequest()->willReturn($request);

        $rule = $this->prophesize(UnprotectionRule::class);
        $rule->matches($request)->willReturn(false);

        $resolver = $this->prophesize(OptionsResolver::class);

        $extension = new CsrfDisablingExtension($requests->reveal(), $rule->reveal());
        $extension->configureOptions($resolver->reveal());

        $resolver->setDefaults(Argument::any())->shouldNotHaveBeenCalled();
    }

    public function testItShouldDisableTheCsrfProtectionWhenTheGivenRuleDoesMatchTheRequest()
    {
        $request  = $this->prophesize(Request::class);
        $requests = $this->prophesize(RequestStack::class);
        $requests->getMasterRequest()->willReturn($request);

        $rule = $this->prophesize(UnprotectionRule::class);
        $rule->matches($request)->willReturn(true);

        $resolver = $this->prophesize(OptionsResolver::class);

        $extension = new CsrfDisablingExtension($requests->reveal(), $rule->reveal());
        $extension->configureOptions($resolver->reveal());

        $resolver->setDefaults(['csrf_protection' => false])->shouldHaveBeenCalled();
    }
}
