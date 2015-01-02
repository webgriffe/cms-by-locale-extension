<?php
/**
 * Created by PhpStorm.
 * User: ddonnini
 * Date: 31/12/14
 * Time: 20.21
 */

class Webgriffe_Cms_Test_Model_Setup extends EcomDev_PHPUnit_Test_Case
{
    protected function setUp()
    {
        $cmsPages = Mage::getModel('cms/page')->getCollection();
        foreach ($cmsPages as $cmsPage) {
            $cmsPage->delete();
        }
        $cmsBlocks = Mage::getModel('cms/block')->getCollection();
        foreach ($cmsBlocks as $cmsBlock) {
            $cmsBlock->delete();
        }
    }

    /**
     * @loadFixture
     */
    public function testTwoWebsitesWithSameLocaleGeneratesOneCmsPageAndOneCmsBlock()
    {
        Mage::getModel('webgriffe_cms/setup', 'core_setup')->generateCmsPage('test', 'Prova test');

        $cmsBlocks = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', array('eq' => 'test'));
        $this->assertCount(1, $cmsBlocks);

        $cmsPage = Mage::getModel('cms/page')->load('Test en_GB', 'title');
        $this->assertNotNull($cmsPage->getId());

        Mage::getModel('webgriffe_cms/setup', 'core_setup')->generateStaticBlock('test', 'Prova test');

        $cmsBlocks = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', array('eq' => 'test'));
        $this->assertCount(1, $cmsBlocks);

        $cmsBlock = Mage::getModel('cms/block')->load('Test en_GB', 'title');
        $this->assertNotNull($cmsBlock->getId());
    }

    /**
     * @loadFixture
     */
    public function testTwoWebsitesWithTwoLocalesGeneratesTwoCmsPagesAndTwoCmsBlocks()
    {
        Mage::getModel('webgriffe_cms/setup', 'core_setup')->generateCmsPage('test', 'Prova test');

        $cmsBlocks = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', array('eq' => 'test'));
        $this->assertCount(2, $cmsBlocks);

        $cmsPage = Mage::getModel('cms/page')->load('Test en_GB', 'title');
        $this->assertNotNull($cmsPage->getId());
        $cmsPage = Mage::getModel('cms/page')->load('Test it_IT', 'title');
        $this->assertNotNull($cmsPage->getId());

        Mage::getModel('webgriffe_cms/setup', 'core_setup')->generateStaticBlock('test', 'Prova test');

        $cmsBlocks = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', array('eq' => 'test'));
        $this->assertCount(2, $cmsBlocks);

        $cmsBlock = Mage::getModel('cms/block')->load('Test en_GB', 'title');
        $this->assertNotNull($cmsBlock->getId());
        $cmsBlock = Mage::getModel('cms/block')->load('Test it_IT', 'title');
        $this->assertNotNull($cmsBlock->getId());
    }
}
