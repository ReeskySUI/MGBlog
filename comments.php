<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$this->comments()->to($comments);
?>

<section id="comments" class="comments-card">
    <?php if ($comments->have()): ?>
        <header class="comments-header">
            <h2><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></h2>
        </header>

        <?php $comments->listComments(); ?>
        <?php $comments->pageNav(_t('上一页'), _t('下一页')); ?>
    <?php endif; ?>

    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <div class="cancel-comment-reply"><?php $comments->cancelReply(); ?></div>
            <h2 id="response"><?php _e('发表评论'); ?></h2>

            <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="comment-form" role="form">
                <?php if ($this->user->hasLogin()): ?>
                    <p class="logged-in-note"><?php _e('当前身份：'); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a></p>
                <?php else: ?>
                    <div class="comment-fields">
                        <label>
                            <span><?php _e('称呼'); ?> *</span>
                            <input type="text" name="author" value="<?php $this->remember('author'); ?>" autocomplete="name" required>
                        </label>
                        <label>
                            <span><?php _e('邮箱'); ?><?php if ($this->options->commentsRequireMail): ?> *<?php endif; ?></span>
                            <input type="email" name="mail" value="<?php $this->remember('mail'); ?>" autocomplete="email"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>>
                        </label>
                        <label>
                            <span><?php _e('网站'); ?><?php if ($this->options->commentsRequireUrl): ?> *<?php endif; ?></span>
                            <input type="url" name="url" value="<?php $this->remember('url'); ?>" autocomplete="url" placeholder="https://"<?php if ($this->options->commentsRequireUrl): ?> required<?php endif; ?>>
                        </label>
                    </div>
                <?php endif; ?>

                <label class="comment-textarea-label" for="comment-textarea"><?php _e('评论内容'); ?> *</label>
                <textarea id="comment-textarea" name="text" rows="7" placeholder="<?php _e('写下你的想法……'); ?>" required><?php $this->remember('text'); ?></textarea>
                <button class="primary-button" type="submit"><?php _e('提交评论'); ?><?php echo mgblog_icon('arrow-right'); ?></button>
            </form>
        </div>
    <?php elseif (!$comments->have()): ?>
        <p class="comments-closed"><?php _e('评论已关闭。'); ?></p>
    <?php endif; ?>
</section>
