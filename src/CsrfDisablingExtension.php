<?php
namespace Dkplus\CsrfApiUnprotectionBundle;

use Dkplus\CsrfApiUnprotectionBundle\UnprotectionRule\UnprotectionRule;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Disables the csrf token validation for all urls that starts with /api/, /app_dev.php/api/,
 * /app_behat.php/api/ or /app_test.php/api/.
 *
 * @Di\Service
 * @Di\Tag(name="form.type_extension", attributes={"alias": "form"} )
 */
class CsrfDisablingExtension extends AbstractTypeExtension
{
    /** @var RequestStack */
    private $requests;

    /** @var UnprotectionRule */
    private $unprotectionRule;

    /**
     * @param RequestStack   $requests
     * @param UnprotectionRule $unprotectionRule
     *
     * @Di\InjectParams({
     *  "requests": @Di\Inject("request_stack")
     * })
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
