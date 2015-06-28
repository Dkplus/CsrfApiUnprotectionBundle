<?php
namespace DkplusTest\CsrfApiUnprotectionBundle\DependencyInjection;

use Dkplus\CsrfApiUnprotectionBundle\CsrfDisablingExtension;
use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Configuration;
use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Extension;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Yaml\Parser;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Extension
 */
class ExtensionTest extends TestCase
{
    public function testItShouldProvideTheRightAlias()
    {
        $this->assertSame('dkplus_csrf_api_unprotection', (new Extension())->getAlias());
    }

    public function testItShouldProvideTheRightConfiguration()
    {
        $this->assertInstanceOf(
            Configuration::class,
            (new Extension())->getConfiguration([], new ContainerBuilder())
        );
    }

    public function testItShouldConfigureTheDisablingExtension()
    {
        $container = $this->createEmptyConfiguration();

        $this->assertTrue($container->hasDefinition('dkplus_csrf_api_unprotection.csrf_disabling_extension'));
        $this->assertInstanceOf(
            CsrfDisablingExtension::class,
            $container->get('dkplus_csrf_api_unprotection.csrf_disabling_extension')
        );
    }

    public function testItShouldAddADefaultRuleWhenNoConfigHasBeenGiven()
    {
        $container = $this->createEmptyConfiguration();
        $this->assertSame(
            ['#^(/app(_[a-zA-Z]*)?.php)?/api/#'],
            $container->getDefinition('dkplus_csrf_api_unprotection.unprotection_rule.uri_patterns')->getArgument(0)
        );
    }

    public function testItShouldAllowCustomRules()
    {
        $container = $this->createFullConfiguration();
        $this->assertSame(
            ['#^/api/#', '#^/rest/#'],
            $container->getDefinition('dkplus_csrf_api_unprotection.unprotection_rule.uri_patterns')->getArgument(0)
        );
    }

    protected function createEmptyConfiguration()
    {
        $configuration = new ContainerBuilder();
        $configuration->set('request_stack', new RequestStack());
        $loader        = new Extension();
        $config        = $this->getEmptyConfig();
        $loader->load(array($config), $configuration);
        return $configuration;
    }

    protected function getEmptyConfig()
    {
        $yaml = '';
        $parser = new Parser();
        return $parser->parse($yaml);
    }

    protected function createFullConfiguration()
    {
        $configuration = new ContainerBuilder();
        $configuration->set('request_stack', new RequestStack());
        $loader        = new Extension();
        $config        = $this->getFullConfig();
        $loader->load(array($config), $configuration);
        return $configuration;
    }

    protected function getFullConfig()
    {
        $yaml = <<<EOF
rules:
    match_uri:
        - "#^/api/#"
        - "#^/rest/#"
EOF;
        $parser = new Parser();
        return $parser->parse($yaml);
    }
}
