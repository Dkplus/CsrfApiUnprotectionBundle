# CSRF API Unprotection Bundle

[![Build Status](https://travis-ci.org/Dkplus/CsrfApiUnprotectionBundle.svg?branch=master)](https://travis-ci.org/Dkplus/CsrfApiUnprotectionBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Dkplus/CsrfApiUnprotectionBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Dkplus/CsrfApiUnprotectionBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Dkplus/CsrfApiUnprotectionBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Dkplus/CsrfApiUnprotectionBundle/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/558fcaa2316338001e000274/badge.svg?style=flat)](https://www.versioneye.com/user/projects/558fcaa2316338001e000274)
[![HHVM Status](http://hhvm.h4cc.de/badge/dkplus/csrf-api-unprotection-bundle.png)](http://hhvm.h4cc.de/package/dkplus/csrf-api-unprotection-bundle)
[![Latest Stable Version](https://poser.pugx.org/dkplus/csrf-api-unprotection-bundle/v/stable.png)](https://packagist.org/packages/dkplus/csrf-api-unprotection-bundle)
[![Latest Unstable Version](https://poser.pugx.org/dkplus/csrf-api-unprotection-bundle/v/unstable.png)](https://packagist.org/packages/dkplus/csrf-api-unprotection-bundle)

When developing stateless REST-APIs you do not want to CSRF token validation.
Fortunately FOSRest [provides the ability to disable it](http://symfony.com/doc/current/bundles/FOSRestBundle/2-the-view-layer.html#csrf-validation).

This solution does not work if you do not have a ROLE for all API users.

This Bundle disables the CSRF token validation based upon the URL of the request.
So if your API has a global prefix like `/api/` you can disable the CSRF token validation for all your API forms. 

# Installation

## Step 1: Download the Bundle

Installation of this Bundle uses composer. It requires you to have Composer installed globally.
For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```bash
composer require dkplus/csrf-api-unprotection-bundle
```

## Step 2: Enable the Bundle within your AppKernel

Then, enable the bundle by adding the following line in the `app/AppKernel.php` file of your project:

```php
<?php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // …

            new Dkplus\CsrfApiUnprotectionBundle\DkplusCsrfApiUnprotectionBundle,
        );

        // …
    }

    // …
}
```

That's everything you need :-)

# Configuration

The default configuration disables the CSRF token validation for all uris
that begins with `/api/` regardless which environment you are using.

```yml
dkplus_csrf_api_unprotection:
    rules:
        matches_uri:
            - "#^(/app(_[a-zA-Z]*)?.php)?/api/#"
```