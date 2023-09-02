# kw_routed_paths

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_routed_paths.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_routed_paths)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_routed_paths/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_routed_paths/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_routed_paths/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_routed_paths)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_routed_paths.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_routed_paths)
[![License](https://poser.pugx.org/alex-kalanis/kw_routed_paths/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_routed_paths)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_routed_paths/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_routed_paths/?branch=master)

Define paths in router of KWCMS. Parse them from REQUEST_URI or other sources. Also allows you
to make links for that router. More at tests and examples.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_routed_paths": ">=2.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_routed_paths" into your app. Extends it for setting your case.

4.) Connect library into your bootstrap process.

5.) Just use class "kalanis\kw_routed_paths\StoreRouted" as data storage

This package contains example file from KWCMS bootstrap. Use it as reference.
