const {
  getDocsNavBar,
  getVersionsLinks,
  getActiveVersion,
} = require("./utils");

module.exports = {
  base: '/boilerplate/',
  title: 'Laravel / AdminLTE 3 Boilerplate',
  description: 'Laravel Boilerplate based on AdminLTE 3 with blade components, user management, roles, permissions, logs viewer, ...',
  head: [
    ['meta', { name: 'theme-color', content: '#3eaf7c' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }]
  ],
  themeConfig: {
    current: '8.x',
    repo: '',
    editLinks: false,
    docsRepo: "sebastienheyd/boilerplate",
    docsDir: '',
    docsBranch: "docs",
    editLinkText: '',
    lastUpdated: false,
    nav: [
      { text: "Guide", link: getActiveVersion().link },
      { text: "Version", items: getVersionsLinks() },
      { text: 'Github', link: 'https://github.com/sebastienheyd/boilerplate' }
    ],
    sidebarDepth: 0,
    sidebar: {
      '/docs/8.x/': getDocsNavBar("8.x"),
      '/docs/7.x/': getDocsNavBar("7.x"),
    }
  },
  plugins: [
    '@vuepress/plugin-back-to-top',
    '@vuepress/plugin-medium-zoom',
  ]
}
