<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');
?>

<div class="page-shell">
    <div class="content-column">
        <header class="page-intro archive-intro">
            <h1><?php $this->archiveTitle(array(
                    'category' => _t('分类：%s'),
                    'search'   => _t('搜索：%s'),
                    'tag'      => _t('标签：%s'),
                    'author'   => _t('%s 的文章')
                ), '', ''); ?></h1>
            <p><?php _e('在历史记录中继续探索。'); ?></p>
        </header>

        <section class="post-list" aria-label="<?php _e('文章列表'); ?>">
            <?php if ($this->have()): ?>
                <?php while ($this->next()): ?>
                    <?php $this->need('components/post-card.php'); ?>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <span class="empty-state-mark"><?php echo mgblog_icon('search'); ?></span>
                    <h2><?php _e('没有找到相关内容'); ?></h2>
                    <p><?php _e('请尝试更换关键词或浏览其他分类。'); ?></p>
                </div>
            <?php endif; ?>
        </section>

        <?php $this->pageNav(_t('上一页'), _t('下一页'), 3, '…'); ?>
    </div>

    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
