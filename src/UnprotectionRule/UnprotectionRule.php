<?php
namespace Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule;

use Symfony\Component\HttpFoundation\Request;

interface UnprotectionRule
{
    public function matches(Request $request);
}
