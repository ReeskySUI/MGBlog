<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
?>
<article class="post-card" itemscope itemtype="https://schema.org/BlogPosting">
    <div class="post-card-content">
        <div class="post-card-category">
            <?php echo mgblog_icon('folder'); ?>
            <?php $this->category(' · ', true, _t('未分类')); ?>
        </div>
        <h2 class="post-card-title" itemprop="headline">
            <a href="<?php $this->permalink(); ?>" itemprop="url"><?php $this->title(); ?></a>
        </h2>
        <p class="post-card-excerpt" itemprop="description"><?php $this->excerpt(150, '…'); ?></p>
        <footer class="post-card-meta">
            <span><?php echo mgblog_icon('calendar'); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d'); ?></time></span>
            <span><?php echo mgblog_icon('clock'); ?><?php echo mgblog_h(mgblog_reading_time($this)); ?> <?php _e('分钟阅读'); ?></span>
            <a class="post-card-read" href="<?php $this->permalink(); ?>"><?php _e('阅读全文'); ?><?php echo mgblog_icon('arrow-right'); ?></a>
        </footer>
    </div>
</article>
