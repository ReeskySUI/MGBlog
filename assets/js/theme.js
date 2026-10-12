(function () {
    'use strict';

    var doc = document;
    var root = doc.documentElement;
    var body = doc.body;

    function setExpanded(element, expanded) {
        if (element) {
            element.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        }
    }

    function closeMenu() {
        var toggle = doc.querySelector('[data-menu-toggle]');
        body.classList.remove('nav-open');
        setExpanded(toggle, false);
        if (toggle) {
            toggle.setAttribute('aria-label', '打开导航');
        }
    }

    function closeSearch() {
        var toggle = doc.querySelector('[data-search-toggle]');
        var panel = doc.querySelector('[data-search-panel]');
        body.classList.remove('search-open');
        setExpanded(toggle, false);
        if (panel) {
            panel.hidden = true;
        }
    }

    function initNavigation() {
        var menuToggle = doc.querySelector('[data-menu-toggle]');
        var searchToggle = doc.querySelector('[data-search-toggle]');
        var searchPanel = doc.querySelector('[data-search-panel]');
        var searchInput = doc.querySelector('[data-search-input]');
        var nav = doc.querySelector('[data-site-nav]');

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                var willOpen = !body.classList.contains('nav-open');
                closeSearch();
                body.classList.toggle('nav-open', willOpen);
                setExpanded(menuToggle, willOpen);
                menuToggle.setAttribute('aria-label', willOpen ? '关闭导航' : '打开导航');
            });
        }

        if (searchToggle && searchPanel) {
            searchToggle.addEventListener('click', function () {
                var willOpen = searchPanel.hidden;
                closeMenu();
                searchPanel.hidden = !willOpen;
                body.classList.toggle('search-open', willOpen);
                setExpanded(searchToggle, willOpen);
                if (willOpen && searchInput) {
                    window.setTimeout(function () {
                        searchInput.focus();
                    }, 40);
                }
            });
        }

        if (nav) {
            nav.addEventListener('click', function (event) {
                if (event.target.closest('a')) {
                    closeMenu();
                }
            });
        }

        doc.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
                closeSearch();
            }
        });
    }

    function initThemeToggle() {
        var toggle = doc.querySelector('[data-theme-toggle]');
        if (!toggle) {
            return;
        }

        function updateLabel() {
            var theme = root.getAttribute('data-theme') || 'light';
            toggle.setAttribute('aria-label', theme === 'dark' ? '切换为浅色' : '切换为深色');
        }

        updateLabel();
        toggle.addEventListener('click', function () {
            var current = root.getAttribute('data-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try {
                localStorage.setItem('mgblog-color-scheme', next);
            } catch (error) {
                // 无存储权限时仍保留当前页面的切换结果。
            }
            updateLabel();
            if (typeof window.mgblogRefreshMermaid === 'function') {
                window.mgblogRefreshMermaid();
            }
        });
    }

    function makeHeadingId(text, index, usedIds) {
        var base = text
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\u4e00-\u9fff-]/g, '')
            .replace(/^-+|-+$/g, '');

        if (!base) {
            base = 'section-' + (index + 1);
        }

        var candidate = base;
        var suffix = 2;
        while (usedIds[candidate] || doc.getElementById(candidate)) {
            candidate = base + '-' + suffix;
            suffix += 1;
        }
        usedIds[candidate] = true;
        return candidate;
    }

    function createLinkIcon() {
        var svg = doc.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('class', 'icon');
        svg.setAttribute('aria-hidden', 'true');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '1.8');
        svg.setAttribute('stroke-linecap', 'round');
        svg.setAttribute('stroke-linejoin', 'round');

        var first = doc.createElementNS('http://www.w3.org/2000/svg', 'path');
        first.setAttribute('d', 'M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1');
        var second = doc.createElementNS('http://www.w3.org/2000/svg', 'path');
        second.setAttribute('d', 'M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1.1-1.1');
        svg.appendChild(first);
        svg.appendChild(second);
        return svg;
    }

    function initToc() {
        var content = doc.querySelector('[data-toc-content]');
        var sidebarRoot = doc.querySelector('[data-sidebar-root]');
        var desktopShell = doc.querySelector('[data-sidebar-toc-shell]');
        var desktopList = doc.querySelector('[data-toc-list]');
        var desktopWidget = doc.querySelector('[data-toc-widget]');
        var mobileList = doc.querySelector('[data-mobile-toc-list]');
        var mobileToggle = doc.querySelector('[data-mobile-toc-toggle]');

        if (!content) {
            return;
        }

        var entries = Array.prototype.slice.call(content.querySelectorAll('h1, h2, h3'))
            .map(function (heading) {
                return {
                    heading: heading,
                    level: Number(heading.tagName.substring(1)),
                    text: heading.textContent.trim(),
                    children: []
                };
            })
            .filter(function (entry) {
                return entry.text !== '';
            });
        var hasDesktopToc = entries.length > 0 && desktopShell && desktopList && desktopWidget;

        if (sidebarRoot) {
            sidebarRoot.setAttribute('data-sidebar-mode', hasDesktopToc ? 'toc' : 'content');
        }
        if (desktopShell) {
            desktopShell.hidden = !hasDesktopToc;
        }

        if (!entries.length) {
            if (desktopWidget) {
                desktopWidget.hidden = true;
            }
            if (mobileToggle) {
                mobileToggle.hidden = true;
            }
            return;
        }

        var usedIds = {};
        entries.forEach(function (entry, index) {
            var heading = entry.heading;
            var headingText = entry.text;
            if (!heading.id) {
                heading.id = makeHeadingId(headingText, index, usedIds);
            } else {
                usedIds[heading.id] = true;
            }

            if (!heading.querySelector('.heading-anchor')) {
                var anchor = doc.createElement('a');
                anchor.className = 'heading-anchor';
                anchor.href = '#' + encodeURIComponent(heading.id);
                anchor.setAttribute('aria-label', '链接到：' + headingText);
                anchor.appendChild(createLinkIcon());
                heading.appendChild(anchor);
            }
        });

        var rootEntries = [];
        var entryStack = [];

        entries.forEach(function (entry) {
            while (entryStack.length && entryStack[entryStack.length - 1].level >= entry.level) {
                entryStack.pop();
            }

            if (entryStack.length) {
                entryStack[entryStack.length - 1].children.push(entry);
            } else {
                rootEntries.push(entry);
            }

            entryStack.push(entry);
        });

        function renderTocList(nodes) {
            var list = doc.createElement('ol');

            nodes.forEach(function (entry) {
                var heading = entry.heading;

                var item = doc.createElement('li');
                item.className = 'toc-level-' + entry.level;
                var link = doc.createElement('a');
                link.href = '#' + encodeURIComponent(heading.id);
                link.textContent = entry.text;
                link.setAttribute('data-toc-link', heading.id);
                item.appendChild(link);

                if (entry.children.length) {
                    item.appendChild(renderTocList(entry.children));
                }

                list.appendChild(item);
            });

            return list;
        }

        var list = renderTocList(rootEntries);

        if (desktopList && desktopWidget) {
            desktopList.replaceChildren(list.cloneNode(true));
            desktopWidget.hidden = false;
        }

        if (mobileList && mobileToggle) {
            mobileList.replaceChildren(list.cloneNode(true));
            mobileToggle.hidden = false;
            mobileToggle.addEventListener('click', function () {
                var willOpen = mobileList.hidden;
                mobileList.hidden = !willOpen;
                setExpanded(mobileToggle, willOpen);
            });
        }

        function setActive(id) {
            doc.querySelectorAll('[data-toc-link]').forEach(function (link) {
                link.classList.toggle('is-active', link.getAttribute('data-toc-link') === id);
            });
        }

        doc.addEventListener('click', function (event) {
            var tocLink = event.target.closest('[data-toc-link]');
            if (!tocLink) {
                return;
            }
            setActive(tocLink.getAttribute('data-toc-link'));
            if (mobileList && window.matchMedia('(max-width: 960px)').matches) {
                mobileList.hidden = true;
                setExpanded(mobileToggle, false);
            }
        });

        setActive(entries[0].heading.id);
        if ('IntersectionObserver' in window) {
            var visibleHeadings = {};
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        visibleHeadings[entry.target.id] = entry.target.offsetTop;
                    } else {
                        delete visibleHeadings[entry.target.id];
                    }
                });

                var visibleIds = Object.keys(visibleHeadings).sort(function (a, b) {
                    return visibleHeadings[b] - visibleHeadings[a];
                });
                if (visibleIds.length) {
                    setActive(visibleIds[0]);
                }
            }, {
                rootMargin: '-18% 0px -68% 0px',
                threshold: 0
            });

            entries.forEach(function (entry) {
                observer.observe(entry.heading);
            });
        }
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        }

        return new Promise(function (resolve, reject) {
            var textarea = doc.createElement('textarea');
            textarea.value = text;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            doc.body.appendChild(textarea);
            textarea.select();
            try {
                doc.execCommand('copy');
                resolve();
            } catch (error) {
                reject(error);
            }
            textarea.remove();
        });
    }

    function createCopyIcon() {
        var wrapper = doc.createElement('span');
        wrapper.innerHTML = '<svg class="icon" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="8" width="11" height="11" rx="2"></rect><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3"></path></svg>';
        return wrapper.firstElementChild;
    }

    function initMarkdownEnhancements() {
        var content = doc.querySelector('[data-toc-content]');
        if (!content) {
            return;
        }

        content.querySelectorAll('table').forEach(function (table) {
            if (table.parentElement && table.parentElement.classList.contains('table-scroll')) {
                return;
            }
            var wrapper = doc.createElement('div');
            wrapper.className = 'table-scroll';
            wrapper.setAttribute('role', 'region');
            wrapper.setAttribute('aria-label', '可横向滚动的数据表格');
            wrapper.setAttribute('tabindex', '0');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });

        content.querySelectorAll('pre').forEach(function (pre) {
            if (pre.querySelector('.code-copy')) {
                return;
            }
            var code = pre.querySelector('code');
            var source = code ? code.textContent : pre.textContent;
            var button = doc.createElement('button');
            button.type = 'button';
            button.className = 'code-copy';
            button.setAttribute('aria-label', '复制代码');
            button.appendChild(createCopyIcon());
            var label = doc.createElement('span');
            label.textContent = '复制';
            button.appendChild(label);
            button.addEventListener('click', function () {
                copyText(source).then(function () {
                    label.textContent = '已复制';
                    window.setTimeout(function () {
                        label.textContent = '复制';
                    }, 1600);
                }).catch(function () {
                    label.textContent = '复制失败';
                });
            });
            pre.appendChild(button);
        });

        content.querySelectorAll('img').forEach(function (image, index) {
            if (!image.hasAttribute('decoding')) {
                image.setAttribute('decoding', 'async');
            }
            if (index > 0 && !image.hasAttribute('loading')) {
                image.setAttribute('loading', 'lazy');
            }
        });
    }

    function isMermaidCodeBlock(pre) {
        var code = pre.querySelector('code');
        var classNames = ((pre.className || '') + ' ' + (code ? code.className || '' : '')).trim();
        return /(?:^|\s)(?:language-|lang-)?mermaid(?:\s|$)/i.test(classNames);
    }

    function loadMermaidRuntime(source) {
        if (window.mermaid) {
            return Promise.resolve(window.mermaid);
        }

        return new Promise(function (resolve, reject) {
            var existing = doc.querySelector('[data-mermaid-runtime]');
            if (existing) {
                existing.addEventListener('load', function () {
                    if (window.mermaid) {
                        resolve(window.mermaid);
                    } else {
                        reject(new Error('Mermaid runtime is unavailable.'));
                    }
                }, { once: true });
                existing.addEventListener('error', reject, { once: true });
                return;
            }

            var script = doc.createElement('script');
            script.src = source;
            script.async = true;
            script.setAttribute('data-mermaid-runtime', '');
            script.addEventListener('load', function () {
                if (window.mermaid) {
                    resolve(window.mermaid);
                } else {
                    reject(new Error('Mermaid runtime is unavailable.'));
                }
            }, { once: true });
            script.addEventListener('error', reject, { once: true });
            doc.head.appendChild(script);
        });
    }

    function mermaidThemeConfig() {
        var isDark = root.getAttribute('data-theme') === 'dark';

        return {
            startOnLoad: false,
            securityLevel: 'strict',
            theme: 'base',
            darkMode: isDark,
            fontFamily: 'Inter, "PingFang SC", "Microsoft YaHei", sans-serif',
            flowchart: {
                useMaxWidth: true
            },
            sequence: {
                useMaxWidth: true
            },
            themeVariables: isDark ? {
                background: '#111827',
                primaryColor: '#142c5e',
                primaryTextColor: '#eef2ff',
                primaryBorderColor: '#60a5fa',
                secondaryColor: '#182234',
                tertiaryColor: '#0f172a',
                lineColor: '#94a3b8',
                textColor: '#e2e8f0',
                mainBkg: '#142c5e',
                nodeBorder: '#60a5fa',
                clusterBkg: '#182234',
                clusterBorder: '#475569',
                edgeLabelBackground: '#111827'
            } : {
                background: '#ffffff',
                primaryColor: '#eff6ff',
                primaryTextColor: '#0f172a',
                primaryBorderColor: '#2563eb',
                secondaryColor: '#f8fafc',
                tertiaryColor: '#fff7ed',
                lineColor: '#64748b',
                textColor: '#1e293b',
                mainBkg: '#eff6ff',
                nodeBorder: '#2563eb',
                clusterBkg: '#f8fafc',
                clusterBorder: '#cbd5e1',
                edgeLabelBackground: '#ffffff'
            }
        };
    }

    function setMermaidView(viewer, view) {
        var showSource = view === 'source';
        var diagram = viewer.querySelector('[data-mermaid-diagram]');
        var source = viewer.querySelector('[data-mermaid-source]');

        if (diagram) {
            diagram.hidden = showSource;
        }
        if (source) {
            source.hidden = !showSource;
        }
        viewer.setAttribute('data-mermaid-view', showSource ? 'source' : 'diagram');
        viewer.querySelectorAll('[data-mermaid-view-button]').forEach(function (button) {
            var active = button.getAttribute('data-mermaid-view-button') === (showSource ? 'source' : 'diagram');
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    function fullscreenElement() {
        return doc.fullscreenElement || doc.webkitFullscreenElement || null;
    }

    function updateMermaidFullscreenControls() {
        var nativeFullscreen = fullscreenElement();
        doc.querySelectorAll('[data-mermaid-viewer]').forEach(function (viewer) {
            var active = nativeFullscreen === viewer || viewer.classList.contains('is-fallback-fullscreen');
            var button = viewer.querySelector('[data-mermaid-fullscreen]');
            var label = button ? button.querySelector('span') : null;
            viewer.classList.toggle('is-fullscreen', active);
            if (button) {
                button.setAttribute('aria-pressed', active ? 'true' : 'false');
                button.setAttribute('aria-label', active ? '退出全屏预览' : '全屏预览');
            }
            if (label) {
                label.textContent = active ? '退出全屏' : '全屏';
            }
        });
    }

    function leaveFallbackFullscreen(viewer) {
        if (!viewer || !viewer.classList.contains('is-fallback-fullscreen')) {
            return;
        }
        viewer.classList.remove('is-fallback-fullscreen');
        body.classList.remove('mermaid-fullscreen-open');
        updateMermaidFullscreenControls();
    }

    function enterFallbackFullscreen(viewer) {
        viewer.classList.add('is-fallback-fullscreen');
        body.classList.add('mermaid-fullscreen-open');
        updateMermaidFullscreenControls();
    }

    function toggleMermaidFullscreen(viewer) {
        if (viewer.classList.contains('is-fallback-fullscreen')) {
            leaveFallbackFullscreen(viewer);
            return;
        }

        if (fullscreenElement() === viewer) {
            var exit = doc.exitFullscreen || doc.webkitExitFullscreen;
            if (exit) {
                exit.call(doc);
            }
            return;
        }

        var request = viewer.requestFullscreen || viewer.webkitRequestFullscreen;
        if (!request) {
            enterFallbackFullscreen(viewer);
            return;
        }

        try {
            var result = request.call(viewer);
            if (result && typeof result.catch === 'function') {
                result.catch(function () {
                    enterFallbackFullscreen(viewer);
                });
            }
        } catch (error) {
            enterFallbackFullscreen(viewer);
        }
    }

    function createMermaidViewer(entry, index) {
        var viewer = doc.createElement('figure');
        viewer.className = 'mermaid-viewer';
        viewer.setAttribute('data-mermaid-viewer', '');
        viewer.setAttribute('data-mermaid-view', 'diagram');

        var toolbar = doc.createElement('div');
        toolbar.className = 'mermaid-toolbar';
        var title = doc.createElement('span');
        title.className = 'mermaid-title';
        title.textContent = 'Mermaid 图表';
        toolbar.appendChild(title);

        var actions = doc.createElement('div');
        actions.className = 'mermaid-actions';
        actions.setAttribute('role', 'group');
        actions.setAttribute('aria-label', '图表显示方式');

        ['diagram', 'source'].forEach(function (view) {
            var button = doc.createElement('button');
            button.type = 'button';
            button.className = 'mermaid-action' + (view === 'diagram' ? ' is-active' : '');
            button.textContent = view === 'diagram' ? '图形' : '代码';
            button.setAttribute('data-mermaid-view-button', view);
            button.setAttribute('aria-pressed', view === 'diagram' ? 'true' : 'false');
            button.addEventListener('click', function () {
                setMermaidView(viewer, view);
            });
            actions.appendChild(button);
        });

        var fullscreenButton = doc.createElement('button');
        fullscreenButton.type = 'button';
        fullscreenButton.className = 'mermaid-action mermaid-fullscreen-button';
        fullscreenButton.setAttribute('data-mermaid-fullscreen', '');
        fullscreenButton.setAttribute('aria-label', '全屏预览');
        fullscreenButton.setAttribute('aria-pressed', 'false');
        var fullscreenLabel = doc.createElement('span');
        fullscreenLabel.textContent = '全屏';
        fullscreenButton.appendChild(fullscreenLabel);
        fullscreenButton.addEventListener('click', function () {
            toggleMermaidFullscreen(viewer);
        });
        actions.appendChild(fullscreenButton);
        toolbar.appendChild(actions);
        viewer.appendChild(toolbar);

        var stage = doc.createElement('div');
        stage.className = 'mermaid-stage';
        var diagram = doc.createElement('div');
        diagram.className = 'mermaid-diagram';
        diagram.setAttribute('data-mermaid-diagram', '');
        diagram.setAttribute('role', 'img');
        diagram.setAttribute('aria-label', '由 Mermaid 代码生成的图表 ' + (index + 1));
        stage.appendChild(diagram);

        var sourcePanel = doc.createElement('div');
        sourcePanel.className = 'mermaid-source-panel';
        sourcePanel.setAttribute('data-mermaid-source', '');
        sourcePanel.hidden = true;
        entry.pre.classList.add('mermaid-source-code');
        sourcePanel.appendChild(entry.pre);
        stage.appendChild(sourcePanel);
        viewer.appendChild(stage);

        entry.viewer = viewer;
        entry.diagram = diagram;
        return viewer;
    }

    function markMermaidFailure(entry) {
        if (entry.pre.previousElementSibling && entry.pre.previousElementSibling.classList.contains('mermaid-error')) {
            return;
        }
        var message = doc.createElement('p');
        message.className = 'mermaid-error';
        message.textContent = '图表渲染失败，已保留原始 Mermaid 代码。';
        entry.pre.parentNode.insertBefore(message, entry.pre);
    }

    function initMermaid() {
        var content = doc.querySelector('[data-toc-content]');
        if (!content) {
            return;
        }

        var entries = Array.prototype.slice.call(content.querySelectorAll('pre'))
            .filter(isMermaidCodeBlock)
            .map(function (pre) {
                var code = pre.querySelector('code');
                return {
                    pre: pre,
                    source: (code ? code.textContent : pre.textContent).trim(),
                    viewer: null,
                    diagram: null
                };
            })
            .filter(function (entry) {
                return entry.source !== '';
            });

        if (!entries.length) {
            return;
        }

        var runtimeSource = body.getAttribute('data-mermaid-src');
        if (!runtimeSource) {
            entries.forEach(markMermaidFailure);
            return;
        }

        var mermaidApi = null;
        var renderQueue = Promise.resolve();
        var renderCount = 0;

        function renderAll() {
            renderQueue = renderQueue.catch(function () {
                // 前一次渲染失败不阻塞后续主题切换重绘。
            }).then(function () {
                mermaidApi.initialize(mermaidThemeConfig());

                return entries.reduce(function (chain, entry, index) {
                    return chain.then(function () {
                        return mermaidApi.parse(entry.source, { suppressErrors: true }).then(function (valid) {
                            if (!valid) {
                                markMermaidFailure(entry);
                                return;
                            }

                            renderCount += 1;
                            var renderId = 'mgblog-mermaid-' + renderCount + '-' + index;
                            return mermaidApi.render(renderId, entry.source).then(function (result) {
                                if (!entry.viewer) {
                                    var parent = entry.pre.parentNode;
                                    var next = entry.pre.nextSibling;
                                    var viewer = createMermaidViewer(entry, index);
                                    if (next) {
                                        parent.insertBefore(viewer, next);
                                    } else {
                                        parent.appendChild(viewer);
                                    }
                                }
                                entry.diagram.innerHTML = result.svg;
                                if (result.bindFunctions) {
                                    result.bindFunctions(entry.diagram);
                                }
                            }).catch(function () {
                                markMermaidFailure(entry);
                            });
                        });
                    });
                }, Promise.resolve());
            });

            return renderQueue;
        }

        loadMermaidRuntime(runtimeSource).then(function (runtime) {
            mermaidApi = runtime;
            window.mgblogRefreshMermaid = renderAll;
            renderAll();
        }).catch(function () {
            entries.forEach(markMermaidFailure);
        });

        doc.addEventListener('fullscreenchange', updateMermaidFullscreenControls);
        doc.addEventListener('webkitfullscreenchange', updateMermaidFullscreenControls);
        doc.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }
            var fallback = doc.querySelector('.mermaid-viewer.is-fallback-fullscreen');
            if (fallback) {
                leaveFallbackFullscreen(fallback);
            }
        });
    }

    function initBackToTop() {
        var button = doc.querySelector('[data-back-to-top]');
        if (!button) {
            return;
        }

        function update() {
            button.classList.toggle('is-visible', window.scrollY > 520);
        }

        update();
        window.addEventListener('scroll', update, { passive: true });
        button.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    initNavigation();
    initThemeToggle();
    initMarkdownEnhancements();
    initMermaid();
    initToc();
    initBackToTop();
}());
