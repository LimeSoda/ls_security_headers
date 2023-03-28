[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-orange.svg)](https://get.typo3.org/version/11)
[![TYPO3 12](https://img.shields.io/badge/TYPO3-12-orange.svg)](https://get.typo3.org/version/12)

# TYPO3 Extension `ls_security_headers`

This extension offers configurable security headers for the frontend.

## Setup

1. Install the extension by using composer
2. Create a "Security Headers" record on the root page and configure the desired headers
3. Validate your configuration with [securityheaders.com](https://securityheaders.com/)

## Infos

- Security Headers that are defined in the .htaccess or in some other server configuration will not be overwritten.
- If EXT:staticfilecache is used, you have to extend the [validHtaccessHeaders extension setting](https://github.com/lochmueller/staticfilecache/blob/master/ext_conf_template.txt#L14).
- Security Headers for the TYPO3 Backend can be defined in AdditionalConfiguration.php with the [BE setting "HTTP"](https://docs.typo3.org/m/typo3/reference-coreapi/11.5/en-us/Configuration/Typo3ConfVars/BE.html#http).

## Ressources

[LIMESODA Website Security](https://www.limesoda.com/leistungen/beratung-consulting/website-security)
