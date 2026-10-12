<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$enableToc = mgblog_option($this->options, 'enableToc', '1') === '1';
$showToc = $enableToc && ($this->is('post') || $this->is('page'));
$showRecentComments = mgblog_option($this->options, 'enableRecentComments', '1') === '1';
$friendLinks = $this->is('index') ? mgblog_friend_links($this->options) : array();
$members = mgblog_members($this->options);
?>

<aside class="sidebar" aria-label="<?php _e('侧栏'); ?>" data-sidebar-root data-sidebar-mode="content">
    <div class="sidebar-sticky">
        <div class="sidebar-persistent" data-sidebar-persistent>
            <div class="sidebar-scroll-body" data-sidebar-scroll-body>
            <?php if (!empty($members)): ?>
                <section class="sidebar-widget members-widget">
                    <h2 class="widget-title"><?php _e('MGHUB 成员'); ?></h2>
                    <ul class="member-grid">
                        <?php foreach ($members as $member): ?>
                            <li>
                                <a href="<?php echo mgblog_h($member['permalink']); ?>">
                                    <span class="member-grid-avatar"><img src="<?php echo mgblog_h($member['avatar']); ?>" alt="<?php echo mgblog_h($member['title']); ?>" loading="lazy" decoding="async"></span>
                                    <span class="member-grid-name"><?php echo mgblog_h($member['title']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($this->is('index') && mgblog_has_sidebar_block($this->options, 'categories')): ?>
                <section class="sidebar-widget category-widget">
                    <h2 class="widget-title"><?php _e('分类'); ?></h2>
                    <ul class="category-list">
                        <?php \Widget\Metas\Category\Rows::alloc()->to($categories); ?>
                        <?php while ($categories->next()): ?>
                            <li>
                                <a href="<?php $categories->permalink(); ?>">
                                    <span class="category-icon" aria-hidden="true"><?php echo mgblog_icon('folder'); ?></span>
                                    <span class="category-copy">
                                        <span class="category-name"><?php $categories->name(); ?></span>
                                        <span class="category-count"><?php echo (int) $categories->count; ?> <?php _e('篇'); ?></span>
                                    </span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if (!empty($friendLinks)): ?>
                <section class="sidebar-widget links-widget">
                    <h2 class="widget-title"><?php _e('友情链接'); ?></h2>
                    <ul class="friend-link-list">
                        <?php foreach ($friendLinks as $friendLink): ?>
                            <li>
                                <a href="<?php echo mgblog_h($friendLink['url']); ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="friend-link-icon" aria-hidden="true"><?php echo mgblog_icon('link'); ?></span>
                                    <span class="friend-link-copy">
                                        <strong><?php echo mgblog_h($friendLink['name']); ?></strong>
                                        <?php if ($friendLink['description'] !== ''): ?>
                                            <small><?php echo mgblog_h($friendLink['description']); ?></small>
                                        <?php endif; ?>
                                    </span>
                                    <?php echo mgblog_icon('arrow-right', 'friend-link-arrow'); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if (mgblog_has_sidebar_block($this->options, 'recent')): ?>
                <section class="sidebar-widget recent-widget">
                    <h2 class="widget-title"><?php _e('最新文章'); ?></h2>
                    <ol class="recent-list">
                        <?php \Widget\Contents\Post\Recent::alloc('pageSize=5')->to($recentPosts); ?>
                        <?php while ($recentPosts->next()): ?>
                            <li>
                                <a href="<?php $recentPosts->permalink(); ?>"><?php $recentPosts->title(); ?></a>
                                <time datetime="<?php $recentPosts->date('c'); ?>"><?php $recentPosts->date('Y-m-d'); ?></time>
                            </li>
                        <?php endwhile; ?>
                    </ol>
                </section>
            <?php endif; ?>

            <?php if ($this->is('index') && $showRecentComments): ?>
                <?php \Widget\Comments\Recent::alloc('pageSize=5')->to($recentComments); ?>
                <section class="sidebar-widget recent-comments-widget">
                    <h2 class="widget-title"><?php _e('最新评论'); ?></h2>
                    <?php if ($recentComments->have()): ?>
                        <ol class="recent-comment-list">
                            <?php while ($recentComments->next()): ?>
                                <li>
                                    <a class="recent-comment-link" href="<?php $recentComments->permalink(); ?>">
                                        <span class="recent-comment-meta">
                                            <strong class="recent-comment-author"><?php echo mgblog_h($recentComments->author); ?></strong>
                                            <time datetime="<?php $recentComments->date('c'); ?>"><?php $recentComments->date('m-d'); ?></time>
                                        </span>
                                        <span class="recent-comment-excerpt"><?php $recentComments->excerpt(48, '…'); ?></span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ol>
                    <?php else: ?>
                        <p class="widget-empty"><?php _e('暂无评论'); ?></p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
            </div>
        </div>

        <?php if (mgblog_has_sidebar_block($this->options, 'feeds')): ?>
            <section class="sidebar-widget feed-widget">
                <h2 class="widget-title"><?php _e('订阅更新'); ?></h2>
                <a class="feed-link" href="<?php $this->options->feedUrl(); ?>"><?php echo mgblog_icon('rss'); ?><span><?php _e('通过 RSS 阅读最新文章'); ?></span><?php echo mgblog_icon('arrow-right'); ?></a>
            </section>
        <?php endif; ?>

        <?php if ($showToc): ?>
            <div class="sidebar-toc-shell" data-sidebar-toc-shell hidden>
                <div class="sidebar-scroll-body" data-sidebar-scroll-body>
                    <section class="sidebar-widget toc-widget" data-toc-widget hidden>
                        <h2 class="widget-title"><?php _e('文章目录'); ?></h2>
                        <nav class="toc-list" aria-label="<?php _e('文章目录'); ?>" data-toc-list></nav>
                    </section>
                </div>
            </div>
        <?php endif; ?>
    </div>
</aside>
