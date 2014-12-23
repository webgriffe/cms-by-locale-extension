Webgriffe Cms By Locale
=======================

Magento extension that generates static content for each store views grouped by locale.

Installation
------------

Please, use [Magento Composer Installer](https://github.com/magento-hackathon/magento-composer-installer) and add `webgriffe/cms-by-locale-extension` to your dependencies. Also add this repository to your `composer.json`.

	"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:webgriffe/cms-by-locale-extension.git"
        }
    ]
    
Usage
-----

You may extend your Setup class from `Webgriffe_Cms_Model_Entity_Setup` or declare the following configs in your extension config.xml file:
    <config>
        <global>
            <resources>
                <YOUR_MODULE_ALIAS_setup>
                    <setup>
                        <module>Webgriffe_Cms</module>
                        <class>Webgriffe_Cms_Model_Entity_Setup</class>
                    </setup>
                </YOUR_MODULE_ALIAS_setup>
            </resources>
        </global>
    </config>


Then, in your data scripts, you may call the methods:
* `$this->generateCmsPage($urlKey, $content)`
* `$this->generateStaticBlock($identifier, $content)`
