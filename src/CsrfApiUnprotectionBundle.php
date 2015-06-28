<?php
namespace Dkplus\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CsrfApiUnprotectionBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (! $this->extension instanceof Extension) {
            $this->extension = new Extension();
        }
        return $this->extension;
    }
}
