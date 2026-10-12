<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');
$enableToc = mgblog_option($this->options, 'enableToc', '1') === '1';
$authorContext = mgblog_author_context($this, $this->options);
?>

<div class="page-shell post-layout">
    <div class="content-column">
        <article class="article-card" itemscope itemtype="https://schema.org/BlogPosting">
            <header class="article-header">
                <h1 itemprop="headline"><?php $this->title(); ?></h1>
                <div class="article-meta">
                    <span><?php echo mgblog_icon('calendar'); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time></span>
                    <?php if ((int) $this->modified > (int) $this->created): ?>
                        <span><?php echo mgblog_icon('clock'); ?><time datetime="<?php echo mgblog_h(mgblog_iso_date($this->modified)); ?>" itemprop="dateModified"><?php _e('更新于'); ?> <?php echo mgblog_h((new \Typecho\Date((int) $this->modified))->format('Y-m-d')); ?></time></span>
                    <?php endif; ?>
                    <span><?php echo mgblog_icon('folder'); ?><?php $this->category(' · ', true, _t('未分类')); ?></span>
                    <span itemprop="author" itemscope itemtype="https://schema.org/Person"><?php echo mgblog_icon('user'); ?><a href="<?php echo mgblog_h($authorContext['url']); ?>" itemprop="url"><span itemprop="name"><?php echo mgblog_h($authorContext['name']); ?></span></a></span>
                    <span><?php echo mgblog_icon('clock'); ?><?php echo mgblog_h(mgblog_reading_time($this)); ?> <?php _e('分钟阅读'); ?></span>
                </div>
                <?php if ($enableToc): ?>
                    <button class="mobile-toc-toggle" type="button" aria-expanded="false" aria-controls="mobile-toc-panel" data-mobile-toc-toggle>
                        <span><?php _e('目录'); ?></span><?php echo mgblog_icon('chevron-down'); ?>
                    </button>
                    <nav id="mobile-toc-panel" class="mobile-toc-panel" aria-label="<?php _e('文章目录'); ?>" data-mobile-toc-list hidden></nav>
                <?php endif; ?>
            </header>

            <div class="markdown-body" itemprop="articleBody" data-toc-content>
                <?php $this->content(); ?>
            </div>

            <?php if ($this->tags): ?>
                <footer class="article-footer">
                    <div class="article-tags"><?php $this->tags('', true, ''); ?></div>
                </footer>
            <?php endif; ?>
        </article>

        <nav class="post-near" aria-label="<?php _e('相邻文章'); ?>">
            <div class="post-near-item post-near-prev">
                <span><?php echo mgblog_icon('arrow-left'); ?><?php _e('上一篇'); ?></span>
                <?php $this->thePrev('%s', _t('已经是第一篇')); ?>
            </div>
            <div class="post-near-item post-near-next">
                <span><?php _e('下一篇'); ?><?php echo mgblog_icon('arrow-right'); ?></span>
                <?php $this->theNext('%s', _t('已经是最后一篇')); ?>
            </div>
        </nav>

        <?php $this->need('comments.php'); ?>
    </div>

    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
