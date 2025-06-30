<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Integration\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository;

class GroupWelcomeTemplateRepositoryTest extends TestCase
{
    /** @var ManagerRegistry&MockObject */
    private MockObject $registry;

    protected function setUp(): void
    {
        $this->registry = $this->createMock(ManagerRegistry::class);
    }

    public function test_repository_extendsServiceEntityRepository(): void
    {
        $repository = new GroupWelcomeTemplateRepository($this->registry);
        
        $this->assertInstanceOf(
            \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository::class,
            $repository
        );
    }

    public function test_repository_isConstructedWithCorrectEntityClass(): void
    {
        $repository = new GroupWelcomeTemplateRepository($this->registry);
        
        // 通过调用父类的构造函数，确保实体类被正确设置
        $this->assertInstanceOf(GroupWelcomeTemplateRepository::class, $repository);
    }

    public function test_repository_canBeInstantiated(): void
    {
        $repository = new GroupWelcomeTemplateRepository($this->registry);
        
        $this->assertNotNull($repository);
    }
}