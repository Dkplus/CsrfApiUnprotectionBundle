<?php
namespace DkplusTest\CsrfApiUnprotectionBundle\UnprotectionRule;

use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UnprotectionRule;
use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UriPatterns;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @covers Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UriPatterns
 */
class UriPatternsTest extends TestCase
{
    public function testItShouldBeARequestMatcher()
    {
        $this->assertInstanceOf(UnprotectionRule::class, new UriPatterns([]));
    }

    /**
     * @dataProvider provideMatchingUris
     *
     * @param string $uri
     */
    public function testItShouldAllowUrisThatPassesOneOfTheExpressions($uri)
    {
        $rule = new UriPatterns(['/^\/api\/.*$/', '/^\/app_dev.php\/api\/.*$/']);
        $this->assertTrue($rule->matches(Request::create($uri)));
    }

    public static function provideMatchingUris()
    {
        return [
            ['/api/'],
            ['/app_dev.php/api/'],
            ['/api/foo/bar'],
        ];
    }

    /**
     * @dataProvider provideNonMatchingUris
     *
     * @param string $uri
     */
    public function testItShouldDenyUrisThatPassesNoneOfTheExpressions($uri)
    {
        $rule = new UriPatterns(['/^\/api\/.*$/', '/^\/app_dev.php\/api\/.*$/']);
        $this->assertFalse($rule->matches(Request::create($uri)));
    }

    public static function provideNonMatchingUris()
    {
        return [
            ['/app_test.php\/api/'],
            ['/apis/foo/bar'],
        ];
    }
}
