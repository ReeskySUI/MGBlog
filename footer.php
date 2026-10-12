<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$footerText = trim((string) $this->options->footerText);
$beianNumber = trim((string) mgblog_option($this->options, 'beianNumber', ''));
?>
</main>

<footer class="site-footer" role="contentinfo">
    <div class="footer-inner">
        <div class="footer-copy">
            <p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a><?php if ($footerText !== ''): ?>。<?php echo mgblog_h($footerText); ?><?php endif; ?><?php if ($beianNumber !== ''): ?><span class="footer-record"> · <a href="https://beian.miit.gov.cn/" target="_blank" rel="external noopener noreferrer"><?php echo mgblog_h($beianNumber); ?></a></span><?php endif; ?></p>
        </div>
        <p><?php _e('由 <a href="https://typecho.org" rel="external">Typecho</a> 驱动'); ?> · MGBlog</p>
    </div>
</footer>

<button class="back-to-top" type="button" aria-label="<?php _e('回到顶部'); ?>" data-back-to-top>
    <?php echo mgblog_icon('chevron-up'); ?>
</button>

<script src="<?php $this->options->themeUrl('assets/js/theme.js?v=1.0.0'); ?>" defer></script>
<?php $this->footer(); ?>
</body>
</html>
