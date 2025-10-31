<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineIpBundle\Traits\IpTraceableAware;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository;
use WechatWorkMediaBundle\Entity\TempMedia;

/**
 * @see https://developer.work.weixin.qq.com/document/path/92366#%E6%B7%BB%E5%8A%A0%E5%85%A5%E7%BE%A4%E6%AC%A2%E8%BF%8E%E8%AF%AD%E7%B4%A0%E6%9D%90
 */
#[ORM\Entity(repositoryClass: GroupWelcomeTemplateRepository::class)]
#[ORM\Table(name: 'wechat_work_group_welcome_template', options: ['comment' => '工作组欢迎模板'])]
class GroupWelcomeTemplate implements \Stringable
{
    use SnowflakeKeyAware;
    use TimestampableAware;
    use BlameableAware;
    use IpTraceableAware;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?AgentInterface $agent = null;

    #[Assert\Length(max: 120)]
    #[ORM\Column(length: 120, nullable: true, options: ['comment' => '欢迎语素材id'])]
    private ?string $templateId = null;

    #[Assert\Type(type: 'bool')]
    #[ORM\Column(nullable: true, options: ['comment' => '是否通知成员'])]
    private ?bool $notify = true;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 65535)]
    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '消息文本内容'])]
    private ?string $textContent = null;

    #[ORM\ManyToOne]
    private ?TempMedia $imageMedia = null;

    #[Assert\Length(max: 255)]
    #[Assert\Url]
    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '图片链接'])]
    private ?string $imagePicUrl = null;

    #[Assert\Length(max: 128)]
    #[ORM\Column(length: 128, nullable: true, options: ['comment' => '链接标题'])]
    private ?string $linkTitle = null;

    #[Assert\Length(max: 255)]
    #[Assert\Url]
    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '链接图片URL'])]
    private ?string $linkPicUrl = null;

    #[Assert\Length(max: 512)]
    #[ORM\Column(length: 512, nullable: true, options: ['comment' => '链接描述'])]
    private ?string $linkDesc = null;

    #[Assert\Length(max: 255)]
    #[Assert\Url]
    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '链接URL'])]
    private ?string $linkUrl = null;

    #[Assert\Length(max: 64)]
    #[ORM\Column(length: 64, nullable: true, options: ['comment' => '小程序标题'])]
    private ?string $miniprogramTitle = null;

    #[ORM\ManyToOne]
    private ?TempMedia $miniprogramMedia = null;

    #[Assert\Length(max: 64)]
    #[ORM\Column(length: 64, nullable: true, options: ['comment' => '小程序AppId'])]
    private ?string $miniprogramAppId = null;

    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '小程序页面路径'])]
    private ?string $miniprogramPage = null;

    #[ORM\ManyToOne]
    private ?TempMedia $fileMedia = null;

    #[ORM\ManyToOne]
    private ?TempMedia $videoMedia = null;

    #[Assert\Type(type: 'bool')]
    #[IndexColumn]
    #[TrackColumn]
    #[Groups(groups: ['admin_curd'])]
    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['comment' => '已同步', 'default' => 0])]
    private ?bool $sync = null;

    public function getAgent(): ?AgentInterface
    {
        return $this->agent;
    }

    public function setAgent(?AgentInterface $agent): void
    {
        $this->agent = $agent;
    }

    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    public function setTemplateId(?string $templateId): void
    {
        $this->templateId = $templateId;
    }

    public function getTextContent(): ?string
    {
        return $this->textContent;
    }

    public function setTextContent(?string $textContent): void
    {
        $this->textContent = $textContent;
    }

    public function isNotify(): ?bool
    {
        return $this->notify;
    }

    public function setNotify(?bool $notify): void
    {
        $this->notify = $notify;
    }

    public function getImageMedia(): ?TempMedia
    {
        return $this->imageMedia;
    }

    public function setImageMedia(?TempMedia $imageMedia): void
    {
        $this->imageMedia = $imageMedia;
    }

    public function getImagePicUrl(): ?string
    {
        return $this->imagePicUrl;
    }

    public function setImagePicUrl(?string $imagePicUrl): void
    {
        $this->imagePicUrl = $imagePicUrl;
    }

    public function getLinkTitle(): ?string
    {
        return $this->linkTitle;
    }

    public function setLinkTitle(?string $linkTitle): void
    {
        $this->linkTitle = $linkTitle;
    }

    public function getLinkPicUrl(): ?string
    {
        return $this->linkPicUrl;
    }

    public function setLinkPicUrl(?string $linkPicUrl): void
    {
        $this->linkPicUrl = $linkPicUrl;
    }

    public function getLinkDesc(): ?string
    {
        return $this->linkDesc;
    }

    public function setLinkDesc(?string $linkDesc): void
    {
        $this->linkDesc = $linkDesc;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(?string $linkUrl): void
    {
        $this->linkUrl = $linkUrl;
    }

    public function getMiniprogramTitle(): ?string
    {
        return $this->miniprogramTitle;
    }

    public function setMiniprogramTitle(?string $miniprogramTitle): void
    {
        $this->miniprogramTitle = $miniprogramTitle;
    }

    public function getMiniprogramMedia(): ?TempMedia
    {
        return $this->miniprogramMedia;
    }

    public function setMiniprogramMedia(?TempMedia $miniprogramMedia): void
    {
        $this->miniprogramMedia = $miniprogramMedia;
    }

    public function getMiniprogramAppId(): ?string
    {
        return $this->miniprogramAppId;
    }

    public function setMiniprogramAppId(?string $miniprogramAppId): void
    {
        $this->miniprogramAppId = $miniprogramAppId;
    }

    public function getMiniprogramPage(): ?string
    {
        return $this->miniprogramPage;
    }

    public function setMiniprogramPage(?string $miniprogramPage): void
    {
        $this->miniprogramPage = $miniprogramPage;
    }

    public function getFileMedia(): ?TempMedia
    {
        return $this->fileMedia;
    }

    public function setFileMedia(?TempMedia $fileMedia): void
    {
        $this->fileMedia = $fileMedia;
    }

    public function getVideoMedia(): ?TempMedia
    {
        return $this->videoMedia;
    }

    public function setVideoMedia(?TempMedia $videoMedia): void
    {
        $this->videoMedia = $videoMedia;
    }

    public function isSync(): ?bool
    {
        return $this->sync;
    }

    public function setSync(?bool $sync): void
    {
        $this->sync = $sync;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
