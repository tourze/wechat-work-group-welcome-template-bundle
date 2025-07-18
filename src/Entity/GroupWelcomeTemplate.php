<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineIpBundle\Attribute\CreateIpColumn;
use Tourze\DoctrineIpBundle\Attribute\UpdateIpColumn;
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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AgentInterface $agent = null;

    #[ORM\Column(length: 120, nullable: true, options: ['comment' => '欢迎语素材id'])]
    private ?string $templateId = null;

    #[ORM\Column(nullable: true, options: ['comment' => '是否通知成员'])]
    private ?bool $notify = true;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '消息文本内容'])]
    private ?string $textContent = null;

    #[ORM\ManyToOne]
    private ?TempMedia $imageMedia = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '图片链接'])]
    private ?string $imagePicUrl = null;

    #[ORM\Column(length: 128, nullable: true, options: ['comment' => '链接标题'])]
    private ?string $linkTitle = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '链接图片URL'])]
    private ?string $linkPicUrl = null;

    #[ORM\Column(length: 512, nullable: true, options: ['comment' => '链接描述'])]
    private ?string $linkDesc = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '链接URL'])]
    private ?string $linkUrl = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => '小程序标题'])]
    private ?string $miniprogramTitle = null;

    #[ORM\ManyToOne]
    private ?TempMedia $miniprogramMedia = null;

    #[ORM\Column(length: 64, nullable: true, options: ['comment' => '小程序AppId'])]
    private ?string $miniprogramAppId = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '小程序页面路径'])]
    private ?string $miniprogramPage = null;

    #[ORM\ManyToOne]
    private ?TempMedia $fileMedia = null;

    #[ORM\ManyToOne]
    private ?TempMedia $videoMedia = null;

    #[IndexColumn]
    #[TrackColumn]
    #[Groups(groups: ['admin_curd'])]
    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['comment' => '已同步', 'default' => 0])]
    private ?bool $sync = null;

    #[CreateIpColumn]
    #[ORM\Column(length: 128, nullable: true, options: ['comment' => '创建时IP'])]
    private ?string $createdFromIp = null;

    #[UpdateIpColumn]
    #[ORM\Column(length: 128, nullable: true, options: ['comment' => '更新时IP'])]
    private ?string $updatedFromIp = null;



    public function getAgent(): ?AgentInterface
    {
        return $this->agent;
    }

    public function setAgent(?AgentInterface $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    public function setTemplateId(?string $templateId): static
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function getTextContent(): ?string
    {
        return $this->textContent;
    }

    public function setTextContent(?string $textContent): static
    {
        $this->textContent = $textContent;

        return $this;
    }

    public function isNotify(): ?bool
    {
        return $this->notify;
    }

    public function setNotify(?bool $notify): static
    {
        $this->notify = $notify;

        return $this;
    }

    public function getImageMedia(): ?TempMedia
    {
        return $this->imageMedia;
    }

    public function setImageMedia(?TempMedia $imageMedia): static
    {
        $this->imageMedia = $imageMedia;

        return $this;
    }

    public function getImagePicUrl(): ?string
    {
        return $this->imagePicUrl;
    }

    public function setImagePicUrl(?string $imagePicUrl): static
    {
        $this->imagePicUrl = $imagePicUrl;

        return $this;
    }

    public function getLinkTitle(): ?string
    {
        return $this->linkTitle;
    }

    public function setLinkTitle(?string $linkTitle): static
    {
        $this->linkTitle = $linkTitle;

        return $this;
    }

    public function getLinkPicUrl(): ?string
    {
        return $this->linkPicUrl;
    }

    public function setLinkPicUrl(?string $linkPicUrl): static
    {
        $this->linkPicUrl = $linkPicUrl;

        return $this;
    }

    public function getLinkDesc(): ?string
    {
        return $this->linkDesc;
    }

    public function setLinkDesc(?string $linkDesc): static
    {
        $this->linkDesc = $linkDesc;

        return $this;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(?string $linkUrl): static
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    public function getMiniprogramTitle(): ?string
    {
        return $this->miniprogramTitle;
    }

    public function setMiniprogramTitle(?string $miniprogramTitle): static
    {
        $this->miniprogramTitle = $miniprogramTitle;

        return $this;
    }

    public function getMiniprogramMedia(): ?TempMedia
    {
        return $this->miniprogramMedia;
    }

    public function setMiniprogramMedia(?TempMedia $miniprogramMedia): static
    {
        $this->miniprogramMedia = $miniprogramMedia;

        return $this;
    }

    public function getMiniprogramAppId(): ?string
    {
        return $this->miniprogramAppId;
    }

    public function setMiniprogramAppId(?string $miniprogramAppId): static
    {
        $this->miniprogramAppId = $miniprogramAppId;

        return $this;
    }

    public function getMiniprogramPage(): ?string
    {
        return $this->miniprogramPage;
    }

    public function setMiniprogramPage(?string $miniprogramPage): static
    {
        $this->miniprogramPage = $miniprogramPage;

        return $this;
    }

    public function getFileMedia(): ?TempMedia
    {
        return $this->fileMedia;
    }

    public function setFileMedia(?TempMedia $fileMedia): static
    {
        $this->fileMedia = $fileMedia;

        return $this;
    }

    public function getVideoMedia(): ?TempMedia
    {
        return $this->videoMedia;
    }

    public function setVideoMedia(?TempMedia $videoMedia): static
    {
        $this->videoMedia = $videoMedia;

        return $this;
    }

    public function isSync(): ?bool
    {
        return $this->sync;
    }

    public function setSync(?bool $sync): self
    {
        $this->sync = $sync;

        return $this;
    }

    public function setCreatedFromIp(?string $createdFromIp): self
    {
        $this->createdFromIp = $createdFromIp;

        return $this;
    }

    public function getCreatedFromIp(): ?string
    {
        return $this->createdFromIp;
    }

    public function setUpdatedFromIp(?string $updatedFromIp): self
    {
        $this->updatedFromIp = $updatedFromIp;

        return $this;
    }

    public function getUpdatedFromIp(): ?string
    {
        return $this->updatedFromIp;
    }
    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
