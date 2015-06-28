<?php
namespace DkplusTest\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\DkplusCsrfApiUnprotectionBundle;
use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Extension;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\DkplusCsrfApiUnprotectionBundle
 */
class DkplusCsrfApiUnprotectionBundleTest extends TestCase
{
    public function testItShouldBeABundle()
    {
        $this->assertInstanceOf(Bundle::class, new DkplusCsrfApiUnprotectionBundle());
    }

    public function testItShouldProvideTheDependencyInjectionExtension()
    {
        $bundle = new DkplusCsrfApiUnprotectionBundle();
        $this->assertInstanceOf(Extension::class, $bundle->getContainerExtension());
    }

    public function testItShouldProvideAlwaysTheSameDependencyInjectionExtension()
    {
        $bundle = new DkplusCsrfApiUnprotectionBundle();
        $this->assertSame($bundle->getContainerExtension(), $bundle->getContainerExtension());
    }
}
