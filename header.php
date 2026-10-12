<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$defaultScheme = mgblog_option($this->options, 'colorScheme', 'auto');
$accentColor = mgblog_hex_color(mgblog_option($this->options, 'accentColor', '#2563eb'));
$brandText = mgblog_brand_text($this->options);
$logoUrl = mgblog_absolute_http_url(mgblog_option($this->options, 'logoUrl', ''), $this->options->siteUrl);
$faviconUrl = mgblog_absolute_http_url(mgblog_option($this->options, 'faviconUrl', ''), $this->options->siteUrl);
$seo = mgblog_seo_context($this, $this->options);
$seoJsonLd = mgblog_seo_jsonld($this, $seo);
$googleSiteVerification = trim((string) mgblog_option($this->options, 'googleSiteVerification', ''));
?>
<!doctype html>
<html lang="zh-CN" data-theme-default="<?php echo mgblog_h($defaultScheme); ?>">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <?php if ($faviconUrl !== ''): ?>
        <link rel="icon" href="<?php echo mgblog_h($faviconUrl); ?>">
        <link rel="shortcut icon" href="<?php echo mgblog_h($faviconUrl); ?>">
    <?php endif; ?>
    <meta name="theme-color" content="#f5f7fb">
    <title><?php echo mgblog_h($seo['title']); ?></title>
    <meta name="robots" content="<?php echo mgblog_h($seo['robots']); ?>">
    <meta name="author" content="<?php echo mgblog_h($seo['author_name']); ?>">
    <?php if (!$this->is('single') && $seo['canonical'] !== ''): ?>
        <link rel="canonical" href="<?php echo mgblog_h($seo['canonical']); ?>">
    <?php endif; ?>
    <?php if ($googleSiteVerification !== ''): ?>
        <meta name="google-site-verification" content="<?php echo mgblog_h($googleSiteVerification); ?>">
    <?php endif; ?>
    <meta property="og:locale" content="zh_CN">
    <meta property="og:type" content="<?php echo mgblog_h($seo['og_type']); ?>">
    <meta property="og:site_name" content="<?php echo mgblog_h($seo['site_title']); ?>">
    <meta property="og:title" content="<?php echo mgblog_h($seo['title']); ?>">
    <?php if ($seo['description'] !== ''): ?>
        <meta property="og:description" content="<?php echo mgblog_h($seo['description']); ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?php echo mgblog_h($seo['social_url'] !== '' ? $seo['social_url'] : $seo['site_url']); ?>">
    <?php if ($seo['image'] !== ''): ?>
        <meta property="og:image" content="<?php echo mgblog_h($seo['image']); ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="<?php echo $seo['image'] !== '' ? 'summary_large_image' : 'summary'; ?>">
    <meta name="twitter:title" content="<?php echo mgblog_h($seo['title']); ?>">
    <?php if ($seo['description'] !== ''): ?>
        <meta name="twitter:description" content="<?php echo mgblog_h($seo['description']); ?>">
    <?php endif; ?>
    <?php if ($seo['image'] !== ''): ?>
        <meta name="twitter:image" content="<?php echo mgblog_h($seo['image']); ?>">
    <?php endif; ?>
    <?php if ($seo['is_article']): ?>
        <?php if ($seo['date_published'] !== ''): ?><meta property="article:published_time" content="<?php echo mgblog_h($seo['date_published']); ?>"><?php endif; ?>
        <?php if ($seo['date_modified'] !== ''): ?><meta property="article:modified_time" content="<?php echo mgblog_h($seo['date_modified']); ?>"><?php endif; ?>
        <?php if ($seo['section'] !== ''): ?><meta property="article:section" content="<?php echo mgblog_h($seo['section']); ?>"><?php endif; ?>
        <?php foreach (preg_split('/\s*,\s*/u', $seo['keywords'], -1, PREG_SPLIT_NO_EMPTY) as $seoTag): ?>
            <meta property="article:tag" content="<?php echo mgblog_h($seoTag); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($seoJsonLd !== ''): ?>
        <script type="application/ld+json"><?php echo $seoJsonLd; ?></script>
    <?php endif; ?>
    <script>
        (function () {
            try {
                var root = document.documentElement;
                var saved = localStorage.getItem('mgblog-color-scheme');
                var preset = root.getAttribute('data-theme-default') || 'auto';
                var theme = saved || preset;
                if (theme === 'auto') {
                    theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                root.setAttribute('data-theme', theme);
            } catch (error) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        }());
    </script>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css?v=1.0.0'); ?>">
    <?php $this->header(http_build_query(array('social' => 0, 'description' => mgblog_h($seo['description'])), '', '&')); ?>
</head>
<body class="<?php echo mgblog_h(mgblog_body_class($this)); ?>" style="--accent: <?php echo mgblog_h($accentColor); ?>" data-mermaid-src="<?php $this->options->themeUrl('assets/vendor/mermaid/mermaid.min.js?v=11.17.2'); ?>">
<a class="skip-link" href="#main-content"><?php _e('跳到正文'); ?></a>

<header class="site-header" data-site-header>
    <div class="header-inner">
        <a class="brand" href="<?php $this->options->siteUrl(); ?>" aria-label="<?php $this->options->title(); ?>">
            <?php if ($logoUrl !== ''): ?>
                <img class="brand-logo" src="<?php echo mgblog_h($logoUrl); ?>" alt="<?php echo mgblog_h($this->options->title); ?>">
            <?php else: ?>
                <span class="brand-mark"><?php echo mgblog_icon('brand'); ?></span>
            <?php endif; ?>
            <span class="brand-text"><?php echo mgblog_h($brandText); ?></span>
        </a>

        <nav class="site-nav" aria-label="<?php _e('主导航'); ?>" data-site-nav>
            <a<?php if ($this->is('index')): ?> class="is-current" aria-current="page"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
            <?php
            \Widget\Contents\Page\Rows::alloc()->to($navPages);
            $navCount = 0;
            while ($navPages->next() && $navCount < 4):
                if ((string) $navPages->template === 'member.php') {
                    continue;
                }
                $navCount++;
            ?>
                <a<?php if ($this->is('page', $navPages->slug)): ?> class="is-current" aria-current="page"<?php endif; ?> href="<?php $navPages->permalink(); ?>"><?php $navPages->title(); ?></a>
            <?php endwhile; ?>
        </nav>

        <div class="header-actions">
            <button class="icon-button" type="button" aria-label="<?php _e('搜索'); ?>" aria-expanded="false" data-search-toggle>
                <?php echo mgblog_icon('search', 'icon-search'); ?>
                <?php echo mgblog_icon('close', 'icon-close'); ?>
            </button>
            <button class="icon-button" type="button" aria-label="<?php _e('切换深浅色'); ?>" data-theme-toggle>
                <?php echo mgblog_icon('moon', 'icon-moon'); ?>
                <?php echo mgblog_icon('sun', 'icon-sun'); ?>
            </button>
            <button class="icon-button menu-toggle" type="button" aria-label="<?php _e('打开导航'); ?>" aria-expanded="false" data-menu-toggle>
                <?php echo mgblog_icon('menu', 'icon-menu'); ?>
                <?php echo mgblog_icon('close', 'icon-close'); ?>
            </button>
        </div>
    </div>

    <div class="search-panel" data-search-panel hidden>
        <form class="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
            <label class="sr-only" for="site-search-input"><?php _e('搜索文章'); ?></label>
            <?php echo mgblog_icon('search'); ?>
            <input id="site-search-input" type="search" name="s" placeholder="<?php _e('输入关键词搜索文章'); ?>" autocomplete="off" data-search-input>
            <button type="submit"><?php _e('搜索'); ?></button>
        </form>
    </div>
</header>

<main id="main-content" class="site-main">
