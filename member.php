<?php
/**
 * MGHUB 成员主页
 *
 * @package custom
 * @author 明关
 * @version 1.0.0
 * @link https://blog.mghub.top
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');

$avatar = mgblog_absolute_http_url(
    (string) ($this->fields->avatar ?? ''),
    $this->options->siteUrl
);
if ($avatar === '') {
    $avatar = rtrim((string) $this->options->themeUrl, '/') . '/assets/img/default-avatar.png?v=1.0.2';
}
$memberRole = trim((string) ($this->fields->role ?? ''));
$memberLinks = mgblog_member_links($this);
?>

<div class="page-shell post-layout">
    <div class="content-column">
        <article class="article-card member-profile-card" itemscope itemtype="https://schema.org/Person">
            <header class="member-profile-header">
                <div class="member-profile-avatar-wrap">
                    <img class="member-profile-avatar" src="<?php echo mgblog_h($avatar); ?>" alt="<?php echo mgblog_h($this->title); ?>" itemprop="image" loading="lazy" decoding="async">
                </div>
                <div class="member-profile-heading">
                    <h1 itemprop="name"><?php $this->title(); ?></h1>
                    <?php if ($memberRole !== ''): ?>
                        <p class="member-profile-role" itemprop="jobTitle"><?php echo mgblog_h($memberRole); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($memberLinks)): ?>
                        <div class="member-profile-links">
                            <?php foreach ($memberLinks as $memberLink): ?>
                                <a href="<?php echo mgblog_h($memberLink['url']); ?>"
                                   itemprop="<?php echo $memberLink['external'] ? 'sameAs' : 'url'; ?>"
                                   <?php if ($memberLink['external']): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                                   aria-label="<?php echo mgblog_h($memberLink['name']); ?>">
                                    <?php echo mgblog_icon($memberLink['icon']); ?><span><?php echo mgblog_h($memberLink['name']); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </header>

            <div class="markdown-body" itemprop="description" data-toc-content>
                <?php $this->content(); ?>
            </div>
        </article>

        <?php $this->need('comments.php'); ?>
    </div>

    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
