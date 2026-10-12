<?php

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 主题设置。
 */
function themeConfig($form)
{
    $brandText = new \Typecho\Widget\Helper\Form\Element\Text(
        'brandText',
        null,
        null,
        _t('页头品牌文字'),
        _t('显示在页面左上角；留空时使用 Typecho 站点名称。')
    );
    $form->addInput($brandText);

    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl',
        null,
        null,
        _t('网站 LOGO 地址'),
        _t('显示在左上角品牌文字前方。可先在“撰写文章”页面上传 LOGO 图片，复制图片链接后粘贴到此处，支持站内相对地址；留空则显示默认图标。')
    );
    $form->addInput($logoUrl);

    $faviconUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'faviconUrl',
        null,
        null,
        _t('网站 Favicon 地址'),
        _t('显示在浏览器标签页标题左侧，建议使用 32×32 或 64×64 的 PNG/ICO 图片；可在“撰写文章”页面上传后复制链接粘贴到此处，留空时浏览器将请求网站根目录的 favicon.ico。')
    );
    $form->addInput($faviconUrl);

    $profileName = new \Typecho\Widget\Helper\Form\Element\Text(
        'profileName',
        null,
        'MGHUB',
        _t('站点默认作者名称'),
        _t('仅用于首页与归档页的站点级 SEO 信息；文章页会自动显示该文的真实作者，无需在此统一设置。')
    );
    $form->addInput($profileName);

    $seoAuthorUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'seoAuthorUrl',
        null,
        null,
        _t('SEO 作者主页'),
        _t('用于结构化数据识别作者；建议填写站内“关于我”页面的完整 URL，留空时使用网站首页。')
    );
    $form->addInput($seoAuthorUrl->addRule('url', _t('请填写合法的 URL 地址')));

    $seoShareImage = new \Typecho\Widget\Helper\Form\Element\Text(
        'seoShareImage',
        null,
        null,
        _t('SEO 默认分享图片'),
        _t('用于首页和归档页的 Open Graph 图片，请填写完整图片 URL；文章页优先读取正文第一张图片。')
    );
    $form->addInput($seoShareImage->addRule('url', _t('请填写合法的 URL 地址')));

    $googleSiteVerification = new \Typecho\Widget\Helper\Form\Element\Text(
        'googleSiteVerification',
        null,
        null,
        _t('Google Search Console 验证码'),
        _t('只填写 google-site-verification 的 content 值，不要粘贴完整 meta 标签。')
    );
    $form->addInput($googleSiteVerification);

    $accentColor = new \Typecho\Widget\Helper\Form\Element\Text(
        'accentColor',
        null,
        '#2563eb',
        _t('主题强调色'),
        _t('填写六位十六进制颜色，例如 #2563eb。非法值会回退到默认蓝色。')
    );
    $form->addInput($accentColor);

    $colorScheme = new \Typecho\Widget\Helper\Form\Element\Radio(
        'colorScheme',
        array(
            'auto'  => _t('跟随系统'),
            'light' => _t('默认浅色'),
            'dark'  => _t('默认深色')
        ),
        'auto',
        _t('默认颜色模式')
    );
    $form->addInput($colorScheme);

    $enableToc = new \Typecho\Widget\Helper\Form\Element\Radio(
        'enableToc',
        array(
            '1' => _t('启用'),
            '0' => _t('关闭')
        ),
        '1',
        _t('文章目录'),
        _t('自动读取正文中的 H1-H3 标题，并按一级、二级、三级结构生成目录。')
    );
    $form->addInput($enableToc);

    $sidebarBlocks = new \Typecho\Widget\Helper\Form\Element\Checkbox(
        'sidebarBlocks',
        array(
            'categories' => _t('显示分类'),
            'recent'     => _t('显示最新文章'),
            'feeds'      => _t('显示订阅入口')
        ),
        array('categories', 'recent', 'feeds'),
        _t('侧栏模块')
    );
    $form->addInput($sidebarBlocks->multiMode());

    $enableRecentComments = new \Typecho\Widget\Helper\Form\Element\Radio(
        'enableRecentComments',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '1',
        _t('首页最新评论'),
        _t('在首页“最新文章”下方显示最近 5 条已审核评论。')
    );
    $form->addInput($enableRecentComments);

    $friendLinks = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'friendLinks',
        null,
        null,
        _t('友情链接'),
        _t('每行一条，格式：名称|https://example.com|简短说明。说明可省略；留空时首页不显示友情链接栏目。')
    );
    $form->addInput($friendLinks);

    $footerText = new \Typecho\Widget\Helper\Form\Element\Text(
        'footerText',
        null,
        '保持独立思考，持续记录与成长。',
        _t('页脚文字'),
        _t('支持纯文本。')
    );
    $form->addInput($footerText);

    $beianNumber = new \Typecho\Widget\Helper\Form\Element\Text(
        'beianNumber',
        null,
        null,
        _t('备案号'),
        _t('例如：蜀ICP备14011608号；留空时不显示备案链接。')
    );
    $form->addInput($beianNumber);
}

/**
 * 独立页面编辑页的默认自定义字段（仅页面，不影响文章）。
 * 成员选择“MGHUB 成员主页”模板后，直接在编辑页填写这些字段即可。
 */
function themePageFields($layout)
{
    $fieldDefs = array(
        array('avatar', 'text', '成员头像', '头像图片的 URL 地址；可先在正文编辑器中上传图片，再复制图片链接粘贴到此处，留空则使用默认头像。'),
        array('role', 'text', '角色 / 身份', '一句话身份，例如“全栈工程师 · 技术研究”，显示在名称下方；留空不显示。'),
        array('github', 'text', 'GitHub 地址', 'GitHub 主页地址，例如 https://github.com/name （可省略 https://）；留空不显示。'),
        array('email', 'text', '联系邮箱', '例如 name@example.com，显示为邮件按钮；留空不显示。'),
        array('website', 'text', '个人网站', '个人主页的 URL 地址；留空不显示。'),
        array('links', 'textarea', '其他链接', '每行一条，格式“名称|URL”，例如：知乎|https://zhihu.com/people/name；自动识别 GitHub / X / 微博 / 知乎 / B站 / 邮箱 / RSS 图标，无法识别时显示通用图标。'),
        array('user', 'text', '关联后台用户名', '填写该成员在 Typecho 后台的登录用户名或昵称；该成员发布的文章，点击作者名将直接跳到本成员主页。留空时按“页面标题 = 作者昵称”自动匹配，仍匹配不到则链接到该作者的文章归档页。')
    );

    foreach ($fieldDefs as $fieldDef) {
        list($name, $type, $label, $description) = $fieldDef;
        $className = $type === 'textarea'
            ? '\Typecho\Widget\Helper\Form\Element\Textarea'
            : '\Typecho\Widget\Helper\Form\Element\Text';
        $element = new $className($name, null, null, _t($label), _t($description));
        $element->input->setAttribute('class', 'text w-100');
        $layout->addItem($element);
    }
}

function mgblog_h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function mgblog_option($options, $name, $default = '')
{
    $value = $options->{$name};

    if (null === $value || '' === trim((string) $value)) {
        return $default;
    }

    return $value;
}

/**
 * 返回页头品牌文字；未设置时使用 Typecho 站点名称。
 */
function mgblog_brand_text($options)
{
    return trim((string) mgblog_option($options, 'brandText', (string) $options->title));
}

function mgblog_hex_color($value, $default = '#2563eb')
{
    return preg_match('/^#[0-9a-fA-F]{6}$/', (string) $value) ? $value : $default;
}

function mgblog_has_sidebar_block($options, $block)
{
    $blocks = $options->sidebarBlocks;

    // Typecho 首次启用主题时，主题配置尚未写入数据库。
    // 此时仍按设置页中的默认选项展示完整侧栏。
    if (!is_array($blocks)) {
        $blocks = array('categories', 'recent', 'feeds');
    }

    return is_array($blocks) && in_array($block, $blocks, true);
}

/**
 * 解析主题设置中的友情链接，仅接受 HTTP/HTTPS 地址。
 */
function mgblog_friend_links($options)
{
    $raw = isset($options->friendLinks) ? trim((string) $options->friendLinks) : '';
    if ($raw === '') {
        return array();
    }

    $links = array();
    $lines = preg_split('/\R/u', $raw);

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || substr($line, 0, 1) === '#') {
            continue;
        }

        $parts = array_map('trim', explode('|', $line, 3));
        if (count($parts) < 2 || $parts[0] === '' || $parts[1] === '') {
            continue;
        }

        $scheme = strtolower((string) parse_url($parts[1], PHP_URL_SCHEME));
        if (!filter_var($parts[1], FILTER_VALIDATE_URL) || !in_array($scheme, array('http', 'https'), true)) {
            continue;
        }

        $links[] = array(
            'name'        => $parts[0],
            'url'         => $parts[1],
            'description' => isset($parts[2]) ? $parts[2] : ''
        );
    }

    return $links;
}

/**
 * 补全链接地址：无协议的外部地址自动添加 https://，站内绝对路径保持原样。
 */
function mgblog_normalize_link($url)
{
    $url = trim((string) $url);
    if ($url === '') {
        return '';
    }
    if (preg_match('#^[a-z][a-z0-9+.-]*:#i', $url)) {
        return $url;
    }
    if (strpos($url, '/') === 0) {
        return $url;
    }

    return 'https://' . $url;
}

/**
 * 获取 MGHUB 成员列表：所有使用“MGHUB 成员主页”模板（member.php）的已发布独立页面。
 */
function mgblog_members($options)
{
    $members = array();
    $defaultAvatar = rtrim((string) $options->themeUrl, '/') . '/assets/img/default-avatar.png?v=1.0.0';

    $pages = \Widget\Contents\Page\Rows::alloc();
    while ($pages->next()) {
        if ((string) $pages->template !== 'member.php') {
            continue;
        }

        $avatar = mgblog_absolute_http_url(
            (string) ($pages->fields->avatar ?? ''),
            $options->siteUrl
        );

        $members[] = array(
            'title'     => (string) $pages->title,
            'permalink' => (string) $pages->permalink,
            'avatar'    => $avatar !== '' ? $avatar : $defaultAvatar
        );
    }

    return $members;
}

/**
 * 获取文章真实作者的展示名称与链接。
 * 优先链接到该作者的成员主页（按 user 字段或页面标题匹配），否则链接到作者的文章归档页。
 */
function mgblog_author_context($archive, $options)
{
    $name = isset($archive->author) ? (string) $archive->author->screenName : '';
    $loginName = isset($archive->author) ? (string) ($archive->author->name ?? '') : '';
    $fallbackUrl = isset($archive->author) ? (string) $archive->author->permalink : '';

    if ($name !== '' && class_exists('\Widget\Contents\Page\Rows')) {
        // 独立别名，避免与侧栏 mgblog_members 的页面查询实例冲突。
        $pages = \Widget\Contents\Page\Rows::alloc('context=author');
        while ($pages->next()) {
            if ((string) $pages->template !== 'member.php') {
                continue;
            }

            $linkedUser = trim((string) ($pages->fields->user ?? ''));
            $matched = ($linkedUser !== '' && ($linkedUser === $name || $linkedUser === $loginName))
                || ((string) $pages->title === $name);

            if ($matched) {
                return array('name' => $name, 'url' => (string) $pages->permalink);
            }
        }
    }

    return array('name' => $name, 'url' => $fallbackUrl);
}

/**
 * 根据名称或地址猜测社交平台图标。
 */
function mgblog_social_icon($hint)
{
    $hint = strtolower((string) $hint);
    $map = array(
        'github'   => 'github',
        'twitter'  => 'twitter',
        'x.com'    => 'twitter',
        'weibo'    => 'weibo',
        'zhihu'    => 'zhihu',
        'bilibili' => 'bilibili',
        'b站'      => 'bilibili',
        'email'    => 'mail',
        '邮箱'     => 'mail',
        'mail'     => 'mail',
        'rss'      => 'rss',
        'feed'     => 'rss',
        '网站'     => 'globe',
        '博客'     => 'globe',
        '主页'     => 'globe',
        'home'     => 'globe',
        'blog'     => 'globe',
        'web'      => 'globe'
    );

    foreach ($map as $needle => $icon) {
        if (strpos($hint, $needle) !== false) {
            return $icon;
        }
    }

    return 'link';
}

/**
 * 汇总成员主页自定义字段中配置的社交链接。
 * 专用字段：website、github、email；links 字段每行一条，格式“名称|URL”。
 */
function mgblog_member_links($archive)
{
    $links = array();

    $website = mgblog_normalize_link($archive->fields->website ?? '');
    if ($website !== '') {
        $links[] = array('name' => _t('个人网站'), 'url' => $website, 'icon' => 'globe', 'external' => true);
    }

    $github = mgblog_normalize_link($archive->fields->github ?? '');
    if ($github !== '') {
        $links[] = array('name' => 'GitHub', 'url' => $github, 'icon' => 'github', 'external' => true);
    }

    $email = trim((string) ($archive->fields->email ?? ''));
    if ($email !== '') {
        $links[] = array('name' => _t('邮箱'), 'url' => 'mailto:' . $email, 'icon' => 'mail', 'external' => false);
    }

    $raw = trim((string) ($archive->fields->links ?? ''));
    if ($raw !== '') {
        foreach (preg_split('/\R/u', $raw) as $line) {
            $line = trim($line);
            if ($line === '' || substr($line, 0, 1) === '#') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line, 2));
            if (count($parts) < 2 || $parts[0] === '' || $parts[1] === '') {
                continue;
            }

            $url = trim($parts[1]);
            $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
            $isMail = $scheme === 'mailto';
            if (!$isMail) {
                $url = mgblog_normalize_link($url);
                $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
                if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array($scheme, array('http', 'https'), true)) {
                    continue;
                }
            }

            $links[] = array(
                'name'     => $parts[0],
                'url'      => $url,
                'icon'     => mgblog_social_icon($parts[0] . ' ' . $url),
                'external' => !$isMail
            );
        }
    }

    return $links;
}

/**
 * 将 HTML 内容压缩为适合搜索摘要的纯文本。
 */
function mgblog_text_excerpt($value, $limit = 180)
{
    $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8');
    $text = trim((string) preg_replace('/\s+/u', ' ', $text));

    if ($text === '') {
        return '';
    }

    $length = function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text);
    if ($length <= $limit) {
        return $text;
    }

    $excerpt = function_exists('mb_substr')
        ? mb_substr($text, 0, $limit, 'UTF-8')
        : substr($text, 0, $limit);

    return rtrim($excerpt, " \t\n\r\0\x0B，。；：、,.!！?？") . '…';
}

/**
 * 将正文中的相对图片地址转换为同站绝对 HTTP/HTTPS 地址。
 */
function mgblog_absolute_http_url($url, $siteUrl)
{
    $url = trim(html_entity_decode((string) $url, ENT_QUOTES, 'UTF-8'));
    $siteUrl = rtrim((string) $siteUrl, '/') . '/';

    if ($url === '') {
        return '';
    }

    if (strpos($url, '//') === 0) {
        $scheme = strtolower((string) parse_url($siteUrl, PHP_URL_SCHEME));
        $url = ($scheme === 'http' ? 'http:' : 'https:') . $url;
    } elseif (!preg_match('#^https?://#i', $url)) {
        if (strpos($url, '/') === 0) {
            $parts = parse_url($siteUrl);
            if (empty($parts['host'])) {
                return '';
            }
            $origin = (isset($parts['scheme']) ? $parts['scheme'] : 'https') . '://' . $parts['host'];
            if (isset($parts['port'])) {
                $origin .= ':' . $parts['port'];
            }
            $url = $origin . $url;
        } else {
            $url = $siteUrl . ltrim($url, '/');
        }
    }

    $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
    return filter_var($url, FILTER_VALIDATE_URL) && in_array($scheme, array('http', 'https'), true)
        ? $url
        : '';
}

/**
 * 仅为文章 SEO 元数据读取正文第一张图片；文章列表不会加载该图片。
 */
function mgblog_content_image($archive, $siteUrl)
{
    $content = isset($archive->content) ? (string) $archive->content : '';
    if (!preg_match('/<img[^>]+(?:data-src|src)=["\']([^"\']+)["\']/i', $content, $matches)) {
        return '';
    }

    return mgblog_absolute_http_url($matches[1], $siteUrl);
}

function mgblog_iso_date($timestamp)
{
    return $timestamp ? gmdate('Y-m-d\\TH:i:s\\Z', (int) $timestamp) : '';
}

/**
 * 汇总页面级 SEO 数据，供 meta、Open Graph 与 JSON-LD 共用。
 */
function mgblog_seo_context($archive, $options)
{
    $siteUrl = rtrim((string) $options->siteUrl, '/') . '/';
    $siteTitle = (string) $options->title;
    $archiveTitle = method_exists($archive, 'getArchiveTitle') ? (string) $archive->getArchiveTitle() : '';
    $archiveUrl = method_exists($archive, 'getArchiveUrl') ? (string) $archive->getArchiveUrl() : '';
    $currentPage = method_exists($archive, 'getCurrentPage') ? (int) $archive->getCurrentPage() : 1;
    $description = method_exists($archive, 'getArchiveDescription')
        ? mgblog_text_excerpt($archive->getArchiveDescription())
        : '';

    if ($description === '') {
        $description = mgblog_text_excerpt($options->description);
    }

    $titlePrefix = $archiveTitle;
    if ($archiveTitle !== '') {
        if ($archive->is('category')) {
            $titlePrefix = '分类 ' . $archiveTitle;
        } elseif ($archive->is('tag')) {
            $titlePrefix = '标签 ' . $archiveTitle;
        } elseif ($archive->is('search')) {
            $titlePrefix = '搜索 ' . $archiveTitle;
        }
    }

    $canonical = '';
    if ($archive->is('single')) {
        $canonical = $archiveUrl;
    } elseif ($currentPage === 1) {
        $canonical = $archive->is('index') ? $siteUrl : $archiveUrl;
    }
    $canonical = mgblog_absolute_http_url($canonical, $siteUrl);

    $isArticle = $archive->is('post') || $archive->is('page');
    $image = $isArticle
        ? mgblog_content_image($archive, $siteUrl)
        : mgblog_absolute_http_url(mgblog_option($options, 'seoShareImage', ''), $siteUrl);

    if ($isArticle) {
        // 文章/页面使用真实作者，链接到其成员主页或文章归档页。
        $articleAuthor = mgblog_author_context($archive, $options);
        $authorName = $articleAuthor['name'];
        $authorUrl = $articleAuthor['url'];
    } else {
        // 首页与归档页使用站点级默认作者信息。
        $authorName = mgblog_option($options, 'profileName', $siteTitle);
        $authorUrl = mgblog_absolute_http_url(mgblog_option($options, 'seoAuthorUrl', $siteUrl), $siteUrl);
    }
    $keywords = method_exists($archive, 'getArchiveKeywords') ? (string) $archive->getArchiveKeywords() : '';
    $section = '';
    if ($archive->is('post') && isset($archive->categories) && is_array($archive->categories) && !empty($archive->categories[0]['name'])) {
        $section = (string) $archive->categories[0]['name'];
    }

    return array(
        'site_url'      => $siteUrl,
        'site_title'    => $siteTitle,
        'alternate_name'=> mgblog_brand_text($options),
        'title'         => $titlePrefix === '' ? $siteTitle : $titlePrefix . ' - ' . $siteTitle,
        'description'   => $description,
        'canonical'     => $canonical,
        'social_url'    => $canonical !== '' ? $canonical : mgblog_absolute_http_url($archiveUrl, $siteUrl),
        'robots'        => $archive->is('404')
            ? 'noindex,nofollow'
            : ($archive->is('search')
                ? 'noindex,follow'
                : 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'),
        'og_type'       => $isArticle ? 'article' : 'website',
        'image'         => $image,
        'author_name'   => (string) $authorName,
        'author_url'    => $authorUrl !== '' ? $authorUrl : $siteUrl,
        'keywords'      => $keywords,
        'section'       => $section,
        'is_article'    => $isArticle,
        'article_type'  => $archive->is('post') ? 'BlogPosting' : 'Article',
        'date_published'=> $isArticle && isset($archive->created) ? mgblog_iso_date($archive->created) : '',
        'date_modified' => $isArticle && isset($archive->modified) ? mgblog_iso_date($archive->modified) : '',
        'is_home'       => $archive->is('index') && $currentPage === 1
    );
}

/**
 * 生成 Google 与通用语义解析器可读取的 JSON-LD 图谱。
 */
function mgblog_seo_jsonld($archive, $seo)
{
    $websiteId = $seo['site_url'] . '#website';
    $blogId = $seo['site_url'] . '#blog';
    $authorId = $seo['author_url'] . '#author';
    $person = array(
        '@type' => 'Person',
        '@id'   => $authorId,
        'name'  => $seo['author_name'],
        'url'   => $seo['author_url']
    );
    $graph = array();

    if ($seo['is_home']) {
        $website = array(
            '@type'       => 'WebSite',
            '@id'         => $websiteId,
            'url'         => $seo['site_url'],
            'name'        => $seo['site_title'],
            'description' => $seo['description'],
            'inLanguage'  => 'zh-CN',
            'publisher'   => array('@id' => $authorId)
        );
        if ($seo['alternate_name'] !== '' && $seo['alternate_name'] !== $seo['site_title']) {
            $website['alternateName'] = array($seo['alternate_name']);
        }

        $graph[] = $website;
        $graph[] = array(
            '@type'       => 'Blog',
            '@id'         => $blogId,
            'url'         => $seo['site_url'],
            'name'        => $seo['site_title'],
            'description' => $seo['description'],
            'inLanguage'  => 'zh-CN',
            'isPartOf'    => array('@id' => $websiteId),
            'author'      => array('@id' => $authorId)
        );
        $graph[] = $person;
    }

    if ($seo['is_article']) {
        $articleFragment = $seo['article_type'] === 'BlogPosting' ? 'blogposting' : 'article';
        $article = array(
            '@type'            => $seo['article_type'],
            '@id'              => $seo['canonical'] . '#' . $articleFragment,
            'url'              => $seo['canonical'],
            'mainEntityOfPage' => array('@type' => 'WebPage', '@id' => $seo['canonical']),
            'headline'         => method_exists($archive, 'getArchiveTitle') ? (string) $archive->getArchiveTitle() : $seo['title'],
            'description'      => $seo['description'],
            'datePublished'    => $seo['date_published'],
            'dateModified'     => $seo['date_modified'],
            'author'           => array('@id' => $authorId),
            'publisher'        => array('@id' => $authorId),
            'isPartOf'         => array('@id' => $blogId),
            'inLanguage'       => 'zh-CN',
            'isAccessibleForFree' => true
        );

        if ($seo['image'] !== '') {
            $article['image'] = array($seo['image']);
        }
        if ($seo['keywords'] !== '') {
            $article['keywords'] = preg_split('/\s*,\s*/u', $seo['keywords'], -1, PREG_SPLIT_NO_EMPTY);
        }
        if ($seo['section'] !== '') {
            $article['articleSection'] = $seo['section'];
        }
        $graph[] = $person;
        $graph[] = $article;
    }

    if (empty($graph)) {
        return '';
    }

    $payload = array(
        '@context' => 'https://schema.org',
        '@graph'   => $graph
    );

    return json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
    );
}

function mgblog_reading_time($archive)
{
    $text = html_entity_decode(strip_tags((string) $archive->content), ENT_QUOTES, 'UTF-8');
    $length = function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text);

    return max(1, (int) ceil($length / 500));
}

function mgblog_body_class($archive)
{
    $classes = array('mgblog');

    if ($archive->is('index')) {
        $classes[] = 'is-index';
    } elseif ($archive->is('post')) {
        $classes[] = 'is-post';
    } elseif ($archive->is('page')) {
        $classes[] = 'is-page';
    } elseif ($archive->is('404')) {
        $classes[] = 'is-404';
    } else {
        $classes[] = 'is-archive';
    }

    return implode(' ', $classes);
}

/**
 * 返回统一风格的内联 SVG 图标。
 */
function mgblog_icon($name, $class = '')
{
    $paths = array(
        'brand' => '<path d="M5 17V7l4 3 3-5 3 5 4-3v10"/><path d="M8.5 15.5c2.2 1.6 4.8 1.6 7 0"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
        'sun' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.66 6.34l1.41-1.41"/>',
        'moon' => '<path d="M20 15.2A8.5 8.5 0 0 1 8.8 4 8.5 8.5 0 1 0 20 15.2Z"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="m6 6 12 12M18 6 6 18"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/>',
        'folder' => '<path d="M3 6.5A2.5 2.5 0 0 1 5.5 4H10l2 2h6.5A2.5 2.5 0 0 1 21 8.5v8a2.5 2.5 0 0 1-2.5 2.5h-13A2.5 2.5 0 0 1 3 16.5Z"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'rss' => '<path d="M5 5a14 14 0 0 1 14 14M5 11a8 8 0 0 1 8 8"/><circle cx="5" cy="19" r="1"/>',
        'github' => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3.3-.4 6.8-1.6 6.8-7A5.5 5.5 0 0 0 19.3 4 5.1 5.1 0 0 0 19.1.5S17.9.1 15 2a13.4 13.4 0 0 0-7 0C5.1.1 3.9.5 3.9.5A5.1 5.1 0 0 0 3.7 4a5.5 5.5 0 0 0-1.5 3.8c0 5.4 3.5 6.6 6.8 7A4.8 4.8 0 0 0 8 18v4"/><path d="M8 19c-3 .9-3-1.5-4-2"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'arrow-left' => '<path d="M19 12H5M11 6l-6 6 6 6"/>',
        'copy' => '<rect x="8" y="8" width="11" height="11" rx="2"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"/>',
        'chevron-up' => '<path d="m6 15 6-6 6 6"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'link' => '<path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1"/><path d="M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14.5 14.5 0 0 1 0 18 14.5 14.5 0 0 1 0-18"/>',
        'twitter' => '<path d="M4 4l6.3 8.3L4.4 20h2.3l4.8-5.9L15.6 20H20l-6.6-8.7L19.3 4h-2.3l-4.3 5.3L8.4 4Z"/>',
        'weibo' => '<path d="M2.5 12S6 6.5 12 6.5 21.5 12 21.5 12 18 17.5 12 17.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3.2"/>',
        'bilibili' => '<path d="m7.5 3 3.2 4"/><path d="m16.5 3-3.2 4"/><rect x="3" y="7" width="18" height="13" rx="3.5"/><path d="M8.5 12.5v2M15.5 12.5v2"/>',
        'zhihu' => '<path d="M7 7.5h10M7.5 7.5l9 9M17 16.5H7"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.6 3.6-6 8-6s8 2.4 8 6"/>'
    );

    if (!isset($paths[$name])) {
        return '';
    }

    $className = trim('icon ' . $class);
    return '<svg class="' . mgblog_h($className) . '" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $paths[$name] . '</svg>';
}

if (defined('__TYPECHO_ADMIN__')) {
    // 模板选择下方的操作提示（右侧“选项”栏）。
    \Typecho\Plugin::factory('admin/write-page.php')->option = function ($page) {
        echo '<p id="mg-template-hint" class="mg-template-hint" hidden>'
            . _t('已选择「MGHUB 成员主页」模板：请在下方“自定义字段”中按提示填写头像与链接，正文区域编写个人介绍；发布后侧栏将自动出现你的头像。')
            . '</p>';
    };

    // 页面底部注入样式与显隐逻辑。
    \Typecho\Plugin::factory('admin/write-page.php')->bottom = function ($page) {
        $memberFields = array('avatar', 'role', 'github', 'email', 'website', 'links', 'user');
        $selectors = array();
        foreach ($memberFields as $memberField) {
            $selectors[] = 'body:not(.mg-member-mode) #custom-field .fields li.field:has([name="fields[' . $memberField . ']"])';
        }
        echo '<style>' . implode(",\n", $selectors) . " { display: none; }\n"
            . '.mg-template-hint { margin: 10px 0 0; padding: 9px 11px; border: 1px solid #bfdbfe; border-radius: 9px; background: #eff6ff; color: #1d4ed8; font-size: 12.5px; line-height: 1.6; }'
            . '</style>';
        echo <<<'SCRIPT'
<script>
(function () {
    var tpl = document.getElementById('template');
    var hint = document.getElementById('mg-template-hint');
    var customField = document.getElementById('custom-field');
    if (!tpl) { return; }

    function sync() {
        var isMember = tpl.value === 'member.php';
        document.body.classList.toggle('mg-member-mode', isMember);
        if (hint) { hint.hidden = !isMember; }
        if (isMember && customField) { customField.open = true; }
    }

    tpl.addEventListener('change', sync);
    sync();
}());
</script>
SCRIPT;
    };
}
