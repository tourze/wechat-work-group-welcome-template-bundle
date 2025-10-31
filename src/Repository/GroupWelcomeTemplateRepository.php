<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

/**
 * @extends ServiceEntityRepository<GroupWelcomeTemplate>
 */
#[Autoconfigure(public: true)]
#[AsRepository(entityClass: GroupWelcomeTemplate::class)]
class GroupWelcomeTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupWelcomeTemplate::class);
    }

    public function save(GroupWelcomeTemplate $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GroupWelcomeTemplate $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
