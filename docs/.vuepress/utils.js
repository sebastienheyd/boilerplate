const ACTIVE_VERSION = "8.x";

function getDocsNavBar(version) {
    switch (version) {
        case "8.x":
            return [
                ["upgrade", 'Upgrade from 7.x to 8.x'],
                ["", 'Introduction'],
                "installation",
                {
                    title: 'Configuration',
                    children: [
                        'configuration/app',
                        'configuration/auth',
                        'configuration/dashboard',
                        'configuration/laratrust',
                        'configuration/locale',
                        'configuration/menu',
                        'configuration/theme',
                    ]
                },
                {
                    title: 'Blade components',
                    children: [
                        'components/card',
                        'components/codemirror',
                        'components/colorpicker',
                        'components/datatable',
                        'components/daterangepicker',
                        'components/datetimepicker',
                        'components/form',
                        'components/icheck',
                        'components/infobox',
                        'components/input',
                        'components/minify',
                        'components/password',
                        'components/select2',
                        'components/smallbox',
                        'components/tinymce',
                        'components/toggle',
                    ]
                },
                {
                    title: 'Dashboard',
                    children: [
                        'dashboard/generate_widget',
                        'dashboard/widget_usage',
                    ]
                },
                'middleware',
                'layout',
                {
                    title: 'Datatables',
                    children: [
                        'datatables/create',
                        'datatables/datasource',
                        'datatables/options',
                        'datatables/column',
                        'datatables/button',
                    ]
                },
                {
                    title: 'How-to',
                    children: [
                        'howto/add_menu_items',
                        'howto/add_navbar_items',
                        'howto/add_permissions',
                        'howto/call_css_js',
                        'howto/change_dashboard',
                        'howto/change_theme',
                        'howto/generate_text_gpt',
                        'howto/scaffold',
                        'howto/user_settings',
                    ]
                },
                {
                    title: 'Javascript plugins',
                    children: [
                        'plugins/bootbox',
                        'plugins/codemirror',
                        'plugins/datatables',
                        'plugins/daterangepicker',
                        'plugins/datetimepicker',
                        'plugins/fileinput',
                        'plugins/fullcalendar',
                        'plugins/icheck',
                        'plugins/moment',
                        'plugins/select2',
                        'plugins/tinymce',
                        'plugins/toastr',
                    ]
                },
                {
                    title: 'Broadcasting',
                    children: [
                        ['broadcasting/configuration', 'Configuration'],
                        'broadcasting/usage',
                        'broadcasting/example',
                    ]
                },
                'language',
                'update',
                'tests',
                'about',
            ];
        case "7.x":
            return [
                ["", 'Introduction'],
                "installation",
                {
                    title: 'Configuration',
                    children: [
                        'configuration/app',
                        'configuration/auth',
                        'configuration/dashboard',
                        'configuration/laratrust',
                        'configuration/locale',
                        'configuration/menu',
                        'configuration/theme',
                    ]
                },
                {
                    title: 'Blade components',
                    children: [
                        'components/card',
                        'components/codemirror',
                        'components/colorpicker',
                        'components/datatable',
                        'components/daterangepicker',
                        'components/datetimepicker',
                        'components/form',
                        'components/icheck',
                        'components/infobox',
                        'components/input',
                        'components/minify',
                        'components/password',
                        'components/select2',
                        'components/smallbox',
                        'components/tinymce',
                        'components/toggle',
                    ]
                },
                {
                    title: 'Dashboard',
                    children: [
                        'dashboard/generate_widget',
                        'dashboard/widget_usage',
                    ]
                },
                {
                    title: 'Datatables',
                    children: [
                        'datatables/create',
                        'datatables/datasource',
                        'datatables/options',
                        'datatables/column',
                        'datatables/button',
                    ]
                },
                {
                    title: 'How-to',
                    children: [
                        'howto/add_menu_items',
                        'howto/add_navbar_items',
                        'howto/add_permissions',
                        'howto/call_css_js',
                        'howto/change_dashboard',
                        'howto/change_theme',
                        'howto/generate_text_gpt',
                        'howto/scaffold',
                        'howto/user_settings',
                    ]
                },
                {
                    title: 'Javascript plugins',
                    children: [
                        'plugins/bootbox',
                        'plugins/codemirror',
                        'plugins/datatables',
                        'plugins/daterangepicker',
                        'plugins/datetimepicker',
                        'plugins/fileinput',
                        'plugins/fullcalendar',
                        'plugins/icheck',
                        'plugins/moment',
                        'plugins/select2',
                        'plugins/tinymce',
                        'plugins/toastr',
                    ]
                },
                {
                    title: 'Broadcasting',
                    children: [
                        ['broadcasting/configuration', 'Configuration'],
                        'broadcasting/usage',
                        'broadcasting/example',
                    ]
                },
                'language',
                'update',
                'troubleshooting',
                'tests',
                'about',
            ];
    }
}

function getVersionsLinks(preLink = "docs") {
    let links = [
        { text: "8.x", link: `/${preLink}/8.x/` },
        { text: "7.x", link: `/${preLink}/7.x/` },
    ].sort((a, b) => a.text < b.text);

    return links;
}

function getActiveVersion() {
    return getVersionsLinks().find((item) => item.text == ACTIVE_VERSION);
}

module.exports = {
    getDocsNavBar,
    getVersionsLinks,
    getActiveVersion,
};
