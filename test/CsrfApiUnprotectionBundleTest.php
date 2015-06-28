<?php
namespace DkplusTest\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\CsrfApiUnprotectionBundle;
use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Extension;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\CsrfApiUnprotectionBundle
 */
class CsrfApiUnprotectionBundleTest extends TestCase
{
    public function testItShouldBeABundle()
    {
        $this->assertInstanceOf(Bundle::class, new CsrfApiUnprotectionBundle());
    }

    public function testItShouldProvideTheDependencyInjectionExtension()
    {
        $bundle = new CsrfApiUnprotectionBundle();
        $this->assertInstanceOf(Extension::class, $bundle->getContainerExtension());
    }

    public function testItShouldProvideAlwaysTheSameDependencyInjectionExtension()
    {
        $bundle = new CsrfApiUnprotectionBundle();
        $this->assertSame($bundle->getContainerExtension(), $bundle->getContainerExtension());
    }
}
