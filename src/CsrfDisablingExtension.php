<?php
namespace Dkplus\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UnprotectionRule;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CsrfDisablingExtension extends AbstractTypeExtension
{
    /** @var RequestStack */
    private $requests;

    /** @var UnprotectionRule */
    private $unprotectionRule;

    public static function getExtendedTypes()
    {
        return [FormType::class];
    }

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
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        if ($this->requests->getMasterRequest()
            && ! $this->unprotectionRule->matches($this->requests->getMasterRequest())
        ) {
            return;
        }

        $resolver->setDefaults(['csrf_protection' => false]);
    }
}
