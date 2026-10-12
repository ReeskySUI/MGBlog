<?php
/**
 * MGBlog - MGHUB 团队博客主题（基于 SaBlog2026 改造）
 *
 * @package MGBlog
 * @author 明关
 * @version 1.0.0
 * @link https://blog.mghub.top
 */

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');
?>

<div class="page-shell">
    <div class="content-column">
        <header class="page-intro">
            <h1><?php $this->options->title(); ?></h1>
            <?php if ($this->options->description): ?>
                <p><?php $this->options->description(); ?></p>
            <?php endif; ?>
        </header>

        <section class="post-list" aria-label="<?php _e('文章列表'); ?>">
            <?php if ($this->have()): ?>
                <?php while ($this->next()): ?>
                    <?php $this->need('components/post-card.php'); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <span class="empty-state-mark"><?php echo mgblog_icon('brand'); ?></span>
                    <h2><?php _e('还没有文章'); ?></h2>
                    <p><?php _e('新的记录会从这里开始。'); ?></p>
                </div>
            <?php endif; ?>
        </section>

        <?php $this->pageNav(_t('上一页'), _t('下一页'), 3, '…'); ?>
    </div>

    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
