<?php
namespace DkplusTest\CsrfApiUnprotectionBundle\DependencyInjection;

use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Configuration;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends TestCase
{
    public function testItShouldBeAConfiguration()
    {
        $this->assertInstanceOf(ConfigurationInterface::class, new Configuration('dkplus_csrf_api_unprotection'));
    }

    public function testItShouldBecomeTheRootNodeAsParameter()
    {
        $configuration = new Configuration('dkplus_csrf_api_unprotection');
        $this->assertSame(
            'dkplus_csrf_api_unprotection',
            $configuration->getConfigTreeBuilder()->buildTree()->getPath()
        );
    }

    /**
     * @dataProvider provideInvalidConfigurations
     *
     * @param array $input
     */
    public function testItShouldForbidInvalidConfigurations(array $input)
    {
        $configuration = new Configuration('dkplus_csrf_api_unprotection');

        $this->setExpectedException(InvalidConfigurationException::class);
        $this->processConfiguration($configuration, $input);
    }

    public static function provideInvalidConfigurations()
    {
        return [
            [['rules' => null]],
            [['rules' => []]],
            [['rules' => ['match_uri' => [null]]]]
        ];
    }

    /**
     * @param Configuration $configuration
     * @param array         $input
     * @return array The processed configuration
     */
    private function processConfiguration(Configuration $configuration, array $input = null)
    {
        $tree = $configuration->getConfigTreeBuilder()->buildTree();
        return $tree->finalize($tree->normalize($input));
    }

    /**
     * @dataProvider provideValidConfigurations
     *
     * @param array|null $input
     * @param array      $processedConfig
     */
    public function testItShouldAcceptValidConfigurations($input, array $processedConfig)
    {
        $configuration = new Configuration('dkplus_csrf_api_unprotection');
        $this->assertSame($processedConfig, $this->processConfiguration($configuration, $input));
    }

    public static function provideValidConfigurations()
    {
        $defaultProcessedConfiguration = ['rules' => ['match_uri' => ['#^(/app(_[a-zA-Z]*)?.php)?/api/#']]];
        return [
            [null,                                          $defaultProcessedConfiguration],
            [[],                                            $defaultProcessedConfiguration],
            [['rules' => ['match_uri' => null]],            ['rules' => ['match_uri' => []]]],
            [['rules' => ['match_uri' => []]],              ['rules' => ['match_uri' => []]]],
            [['rules' => ['match_uri' => ['/^\/api/.*/']]], ['rules' => ['match_uri' => ['/^\/api/.*/']]]],
            [['rules' => ['match_uri' => '/^\/api/.*/']],   ['rules' => ['match_uri' => ['/^\/api/.*/']]]],
        ];
    }
}
