<?php
/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 11/09/14
 * Time: 12:47
 */

class Webgriffe_Cms_Model_Setup extends Mage_Core_Model_Resource_Setup
{
    public function generateCmsPage($urlKey, $content)
    {
        foreach (Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', $urlKey)->getItems() as $item) {
            $item->delete();
        }

        $storesByLocales = $this->organizeStoresByLocale();

        foreach ($storesByLocales as $locale => $storeIds) {
            $this->createCmsPage($urlKey, $content, $locale, $storeIds);
        }
    }

    public function generateStaticBlock($identifier, $content)
    {
        foreach (Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', $identifier)->getItems() as $item) {
            $item->delete();
        }

        $storesByLocales = $this->organizeStoresByLocale();

        foreach ($storesByLocales as $locale => $storeIds) {
            $this->createStaticBlock($identifier, $content, $locale, $storeIds);
        }
    }

    /**
     * @return array
     */
    private function organizeStoresByLocale()
    {
        $locales = array();

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $locales[$store->getConfig('general/locale/code')][] = $store->getId();
        }
        return $locales;
    }

    /**
     * @param $urlKey
     * @param $content
     * @param $locale
     * @param $storeIds
     */
    private function createCmsPage($urlKey, $content, $locale, $storeIds)
    {
        Mage::getModel('cms/page')
            ->setIdentifier($urlKey)
            ->setTitle(ucfirst($urlKey) . ' ' . $locale)
            ->setRootTemplate('one_column')
            ->setContent($content)
            ->setStores($storeIds)
            ->save();
    }

    /**
     * @param $identifier
     * @param $content
     * @param $locale
     * @param $storeIds
     */
    private function createStaticBlock($identifier, $content, $locale, $storeIds)
    {
        Mage::getModel('cms/block')
            ->setIdentifier($identifier)
            ->setTitle(ucfirst($identifier) . ' ' . $locale)
            ->setContent($content)
            ->setStores($storeIds)
            ->save();
    }
}
