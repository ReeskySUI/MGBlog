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
        <article class="article-card page-card" itemscope itemtype="https://schema.org/Article">
            <header class="article-header">
                <h1 itemprop="headline"><?php $this->title(); ?></h1>
                <div class="article-meta">
                    <span><?php echo mgblog_icon('calendar'); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time></span>
                    <?php if ((int) $this->modified > (int) $this->created): ?>
                        <span><?php echo mgblog_icon('clock'); ?><time datetime="<?php echo mgblog_h(mgblog_iso_date($this->modified)); ?>" itemprop="dateModified"><?php _e('更新于'); ?> <?php echo mgblog_h((new \Typecho\Date((int) $this->modified))->format('Y-m-d')); ?></time></span>
                    <?php endif; ?>
                    <span itemprop="author" itemscope itemtype="https://schema.org/Person"><?php echo mgblog_icon('user'); ?><a href="<?php echo mgblog_h($authorContext['url']); ?>" itemprop="url"><span itemprop="name"><?php echo mgblog_h($authorContext['name']); ?></span></a></span>
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
        </article>

        <?php $this->need('comments.php'); ?>
    </div>

    <?php $this->need('sidebar.php'); ?>
</div>

<?php $this->need('footer.php'); ?>
