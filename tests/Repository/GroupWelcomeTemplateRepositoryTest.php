<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository;

/**
 * @internal
 */
#[CoversClass(GroupWelcomeTemplateRepository::class)]
#[RunTestsInSeparateProcesses]
final class GroupWelcomeTemplateRepositoryTest extends AbstractRepositoryTestCase
{
    protected function getRepository(): GroupWelcomeTemplateRepository
    {
        return self::getService(GroupWelcomeTemplateRepository::class);
    }

    protected function onSetUp(): void
    {
        // Setup logic if needed
    }

    public function testRepositoryInstance(): void
    {
        $this->assertInstanceOf(GroupWelcomeTemplateRepository::class, $this->getRepository());
    }

    public function testSaveWithFlush(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Test content');

        $this->getRepository()->save($template, true);

        $this->assertNotNull($template->getId());
    }

    public function testSaveWithoutFlush(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Test content');

        $this->getRepository()->save($template, false);

        // Snowflake ID is generated on prePersist, so it will have an ID even without flush
        $this->assertNotNull($template->getId());

        // Clear entity manager to ensure we're not getting from identity map
        self::getEntityManager()->clear();

        // Now it should not be findable in database without flush
        $found = $this->getRepository()->find($template->getId());
        $this->assertNull($found);
    }

    public function testFindWithValidIdShouldReturnEntity(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Test content');
        $this->getRepository()->save($template, true);

        $found = $this->getRepository()->find($template->getId());

        $this->assertInstanceOf(GroupWelcomeTemplate::class, $found);
        $this->assertSame($template->getId(), $found->getId());
    }

    public function testFindOneByRespectOrderBy(): void
    {
        $template1 = new GroupWelcomeTemplate();
        $template1->setTextContent('A content');
        $this->getRepository()->save($template1, true);

        $template2 = new GroupWelcomeTemplate();
        $template2->setTextContent('B content');
        $this->getRepository()->save($template2, true);

        $found = $this->getRepository()->findOneBy([], ['textContent' => 'ASC']);

        $this->assertInstanceOf(GroupWelcomeTemplate::class, $found);
        $this->assertSame('A content', $found->getTextContent());
    }

    public function testQueryWithAgentAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Agent association test');
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['agent' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithImageMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Image media test');
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['imageMedia' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithAgentAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count agent test');
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['agent' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testQueryWithNullTemplateIdShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null template ID test');
        $template->setTemplateId(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['templateId' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullNotifyShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null notify test');
        $template->setNotify(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['notify' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithNullTemplateIdShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null template ID');
        $template->setTemplateId(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['templateId' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullNotifyShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null notify');
        $template->setNotify(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['notify' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testFindOneByShouldRespectOrderByForSorting(): void
    {
        $template1 = new GroupWelcomeTemplate();
        $template1->setTextContent('Z content');
        $this->getRepository()->save($template1, true);

        $template2 = new GroupWelcomeTemplate();
        $template2->setTextContent('A content');
        $this->getRepository()->save($template2, true);

        $found = $this->getRepository()->findOneBy([], ['textContent' => 'ASC']);

        $this->assertInstanceOf(GroupWelcomeTemplate::class, $found);
        $this->assertSame('A content', $found->getTextContent());
    }

    public function testQueryWithMiniprogramMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Miniprogram media test');
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['miniprogramMedia' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithFileMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('File media test');
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['fileMedia' => null]);

        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithVideoMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Video media test');
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['videoMedia' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithMiniprogramMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count miniprogram media test');
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['miniprogramMedia' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithFileMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count file media test');
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['fileMedia' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithVideoMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count video media test');
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['videoMedia' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testQueryWithNullImagePicUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null image pic url test');
        $template->setImagePicUrl(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['imagePicUrl' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullLinkTitleShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null link title test');
        $template->setLinkTitle(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['linkTitle' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullLinkUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null link url test');
        $template->setLinkUrl(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['linkUrl' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullMiniprogramTitleShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null miniprogram title test');
        $template->setMiniprogramTitle(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['miniprogramTitle' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullMiniprogramPageShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null miniprogram page test');
        $template->setMiniprogramPage(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['miniprogramPage' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullSyncShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null sync test');
        $template->setSync(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['sync' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithNullImagePicUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null image pic url');
        $template->setImagePicUrl(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['imagePicUrl' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullLinkTitleShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null link title');
        $template->setLinkTitle(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['linkTitle' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullLinkUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null link url');
        $template->setLinkUrl(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['linkUrl' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullMiniprogramTitleShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null miniprogram title');
        $template->setMiniprogramTitle(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['miniprogramTitle' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullMiniprogramPageShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null miniprogram page');
        $template->setMiniprogramPage(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['miniprogramPage' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullSyncShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null sync');
        $template->setSync(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['sync' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithImageMediaAssociationShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count image media test');
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['imageMedia' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testQueryWithNullTextContentShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['textContent' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithNullTextContentShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['textContent' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testQueryWithNullLinkPicUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null link pic url test');
        $template->setLinkPicUrl(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['linkPicUrl' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullLinkDescShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null link desc test');
        $template->setLinkDesc(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['linkDesc' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testQueryWithNullMiniprogramAppIdShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Null miniprogram app id test');
        $template->setMiniprogramAppId(null);
        $this->getRepository()->save($template, true);

        $results = $this->getRepository()->findBy(['miniprogramAppId' => null]);

        $this->assertIsArray($results);
        $this->assertGreaterThanOrEqual(1, count($results));
    }

    public function testCountWithNullLinkPicUrlShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null link pic url');
        $template->setLinkPicUrl(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['linkPicUrl' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullLinkDescShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null link desc');
        $template->setLinkDesc(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['linkDesc' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testCountWithNullMiniprogramAppIdShouldWork(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTextContent('Count null miniprogram app id');
        $template->setMiniprogramAppId(null);
        $this->getRepository()->save($template, true);

        $count = $this->getRepository()->count(['miniprogramAppId' => null]);

        $this->assertGreaterThanOrEqual(1, $count);
    }

    public function testFindOneByRespectOrderByDescending(): void
    {
        $template1 = new GroupWelcomeTemplate();
        $template1->setTextContent('A content');
        $this->getRepository()->save($template1, true);

        $template2 = new GroupWelcomeTemplate();
        $template2->setTextContent('Z content');
        $this->getRepository()->save($template2, true);

        $found = $this->getRepository()->findOneBy([], ['textContent' => 'DESC']);

        $this->assertInstanceOf(GroupWelcomeTemplate::class, $found);
        $this->assertSame('Z content', $found->getTextContent());
    }

    public function testFindOneByWithMultipleOrderByFields(): void
    {
        $template1 = new GroupWelcomeTemplate();
        $template1->setTextContent('Same content');
        $template1->setNotify(true);
        $this->getRepository()->save($template1, true);

        $template2 = new GroupWelcomeTemplate();
        $template2->setTextContent('Same content');
        $template2->setNotify(false);
        $this->getRepository()->save($template2, true);

        $found = $this->getRepository()->findOneBy(
            ['textContent' => 'Same content'],
            ['notify' => 'DESC', 'id' => 'ASC']
        );

        $this->assertInstanceOf(GroupWelcomeTemplate::class, $found);
        $this->assertTrue($found->isNotify());
    }

    protected function createNewEntity(): object
    {
        $entity = new GroupWelcomeTemplate();
        $entity->setTextContent('Test GroupWelcomeTemplate ' . uniqid());
        $entity->setNotify(true);

        return $entity;
    }
}
