<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

/**
 * @method GroupWelcomeTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupWelcomeTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupWelcomeTemplate[]    findAll()
 * @method GroupWelcomeTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupWelcomeTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupWelcomeTemplate::class);
    }
}
