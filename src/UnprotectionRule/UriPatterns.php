<?php
namespace Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule;

use Assert\Assertion;
use Symfony\Component\HttpFoundation\Request;

final class UriPatterns implements UnprotectionRule
{
    /** @var string[] */
    private $patterns;

    public function __construct(array $patterns)
    {
        foreach ($patterns as $each) {
            Assertion::string($each);
        }
        $this->patterns = $patterns;
    }

    public function matches(Request $request)
    {
        foreach ($this->patterns as $each) {
            if (preg_match($each, $request->getRequestUri())) {
                return true;
            }
        }
        return false;
    }
}
