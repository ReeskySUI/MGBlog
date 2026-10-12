<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->need('header.php');
?>

<div class="error-layout">
    <section class="error-card">
        <span class="error-code">404</span>
        <h1><?php _e('页面没有找到'); ?></h1>
        <p><?php _e('内容可能已移动、删除，或者地址输入有误。'); ?></p>
        <form class="search-form error-search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <label class="sr-only" for="error-search-input"><?php _e('搜索文章'); ?></label>
            <?php echo mgblog_icon('search'); ?>
            <input id="error-search-input" type="search" name="s" placeholder="<?php _e('搜索其他文章'); ?>" autofocus>
            <button type="submit"><?php _e('搜索'); ?></button>
        </form>
        <a class="text-link" href="<?php $this->options->siteUrl(); ?>"><?php echo mgblog_icon('arrow-left'); ?><?php _e('返回首页'); ?></a>
    </section>
</div>

<?php $this->need('footer.php'); ?>
