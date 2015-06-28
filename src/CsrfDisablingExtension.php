<?php
namespace Dkplus\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UnprotectionRule;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CsrfDisablingExtension extends AbstractTypeExtension
{
    /** @var RequestStack */
    private $requests;

    /** @var UnprotectionRule */
    private $unprotectionRule;

    /**
     * @param RequestStack   $requests
     * @param UnprotectionRule $unprotectionRule
     */
    public function __construct(RequestStack $requests, UnprotectionRule $unprotectionRule)
    {
        $this->requests         = $requests;
        $this->unprotectionRule = $unprotectionRule;
    }

    public function getExtendedType()
    {
        return 'form';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        if (! $this->unprotectionRule->matches($this->requests->getMasterRequest())) {
            return;
        }

        $resolver->setDefaults(['csrf_protection' => false]);
    }
}
