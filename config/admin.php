<?php

return [

    /*
    |--------------------------------------------------------------------------
    | dcat-admin name
    |--------------------------------------------------------------------------
    |
    | This value is the name of dcat-admin, This setting is displayed on the
    | login page.
    |
    */
    'name' => 'aner admin后台管理系统',

    /*
    |--------------------------------------------------------------------------
    | dcat-admin logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages. You can also set it as an image by using a
    | `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
    |
    */
    'logo' => '<img src="/static/logo/aner_admin_favicon.png"> &nbsp; aner admin',

    /*
    |--------------------------------------------------------------------------
    | dcat-admin mini logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages when the sidebar menu is collapsed. You can
    | also set it as an image by using a `img` tag, eg
    | '<img src="http://logo-url" alt="Admin logo">'.
    |
    */
    'logo-mini' => '<img src="/static/logo/aner_admin_favicon.png">',

    /*
    |--------------------------------------------------------------------------
    | dcat-admin favicon
    |--------------------------------------------------------------------------
    |
    */
    'favicon' => null,

    /*
     |--------------------------------------------------------------------------
     | User default avatar
     |--------------------------------------------------------------------------
     |
     | Set a default avatar for newly created users.
     |
     */
    'default_avatar' => '/static/logo/aner_admin_favicon.png',

    /*
    |--------------------------------------------------------------------------
    | dcat-admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [
        'domain' => env('ADMIN_ROUTE_DOMAIN'),

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'admin'],

        'enable_session_middleware' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin install directory
    |--------------------------------------------------------------------------
    |
    | The installation directory of the controller and routing configuration
    | files of the administration page. The default is `app/Admin`, which must
    | be set before running `artisan admin::install` to take effect.
    |
    */
    'directory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    | dcat-admin html title
    |--------------------------------------------------------------------------
    |
    | Html title for all pages.
    |
    */
    'title' => 'Admin',

    /*
    |--------------------------------------------------------------------------
    | Assets hostname
    |--------------------------------------------------------------------------
    |
   */
    'assets_server' => env('ADMIN_ASSETS_SERVER'),

    /*
    |--------------------------------------------------------------------------
    | Access via `https`
    |--------------------------------------------------------------------------
    |
    | If your page is going to be accessed via https, set it to `true`.
    |
    */
    'https' => env('ADMIN_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | dcat-admin auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    |
    */
    'auth' => [
        'enable' => true,

        'controller' => App\Admin\Controllers\AuthController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Dcat\Admin\Models\Administrator::class,
            ],
        ],

        // Add "remember me" to login form
        'remember' => true,

        // All method to path like: auth/users/*/edit
        // or specific method to path like: get:auth/users.
        'except' => [
            'auth/login',
            'auth/logout',
        ],

        'enable_session_middleware' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | The global Grid setting
    |--------------------------------------------------------------------------
    */
    'grid' => [

        // The global Grid action display class.
        'grid_action_class' => Dcat\Admin\Grid\Displayers\Actions::class,

        // The global Grid batch action display class.
        'batch_action_class' => Dcat\Admin\Grid\Tools\BatchActions::class,

        // The global Grid pagination display class.
        'paginator_class' => Dcat\Admin\Grid\Tools\Paginator::class,

        'actions' => [
            'view' => Dcat\Admin\Grid\Actions\Show::class,
            'edit' => Dcat\Admin\Grid\Actions\Edit::class,
            'quick_edit' => Dcat\Admin\Grid\Actions\QuickEdit::class,
            'delete' => Dcat\Admin\Grid\Actions\Delete::class,
            'batch_delete' => Dcat\Admin\Grid\Tools\BatchDelete::class,
        ],

        // The global Grid column selector setting.
        'column_selector' => [
            'store' => Dcat\Admin\Grid\ColumnSelector\SessionStore::class,
            'store_params' => [
                'driver' => 'file',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin helpers setting.
    |--------------------------------------------------------------------------
    */
    'helpers' => [
        'enable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin permission setting
    |--------------------------------------------------------------------------
    |
    | Permission settings for all admin pages.
    |
    */
    'permission' => [
        // Whether enable permission.
        'enable' => true,

        // All method to path like: auth/users/*/edit
        // or specific method to path like: get:auth/users.
        'except' => [
            '/',
            'auth/login',
            'auth/logout',
            'auth/setting',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin menu setting
    |--------------------------------------------------------------------------
    |
    */
    'menu' => [
        'cache' => [
            // enable cache or not
            'enable' => false,
            'store'  => 'file',
        ],

        // Whether enable menu bind to a permission.
        'bind_permission' => true,

        // Whether enable role bind to menu.
        'role_bind_menu' => true,

        // Whether enable permission bind to menu.
        'permission_bind_menu' => true,

        'default_icon' => 'feather icon-circle',
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin upload setting
    |--------------------------------------------------------------------------
    |
    | File system configuration for form upload files and images, including
    | disk and upload path.
    |
    */
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => env('UPLOAD_DISK', 'admin'),

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | dcat-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for dcat-admin builtin model & tables.
    |
    */
    'database' => [

        // Database connection for following tables.
        'connection' => '',

        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => Dcat\Admin\Models\Administrator::class,

        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => Dcat\Admin\Models\Role::class,

        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Dcat\Admin\Models\Permission::class,

        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => Dcat\Admin\Models\Menu::class,

        // Pivot table for table above.
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
        'permission_menu_table'  => 'admin_permission_menu',
        'settings_table'         => 'admin_settings',
        'extensions_table'       => 'admin_extensions',
        'extension_histories_table' => 'admin_extension_histories',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    */
    'layout' => [
        // default, blue, blue-light, green
        'color' => 'default',

        // sidebar-separate
        'body_class' => [],

        'horizontal_menu' => false,

        'sidebar_collapsed' => false,

        // light, primary, dark
        'sidebar_style' => 'light',

        'dark_mode_switch' => false,

        // bg-primary, bg-info, bg-warning, bg-success, bg-danger, bg-dark
        'navbar_color' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | The exception handler class
    |--------------------------------------------------------------------------
    |
    */
    'exception_handler' => Dcat\Admin\Exception\Handler::class,

    /*
    |--------------------------------------------------------------------------
    | Enable default breadcrumb
    |--------------------------------------------------------------------------
    |
    | Whether enable default breadcrumb for every page content.
    */
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Extension
    |--------------------------------------------------------------------------
    */
    'extension' => [
        // When you use command `php artisan admin:ext-make` to generate extensions,
        // the extension files will be generated in this directory.
        'dir' => base_path('dcat-admin-extensions'),
        'media-manager' => [
            // 'disk'        => 'public',
            'disk' => ['public', 'admin'], // 仅 v1.03 后支持多文件
            // 'allowed_ext' => 'jpg,jpeg,png,pdf,doc,docx,zip'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | 富文本相关设置
    |--------------------------------------------------------------------------
    */
    // 富文本图片、文件上传规则（与系统配置一致）
    "upload_disk"=> env('UPLOAD_DISK', 'admin'),
    /*
    |--------------------------------------------------------------------------
    | 会员相关设置
    |--------------------------------------------------------------------------
    */
    "users"=> [
        // 会员标识字段
        // 会员注册、登录等使用的验证字段
        // phone, email, account
        "user_identity"=> ['phone'],
        // 头像字段是否使用(此项目中是否需要用到头像，下同)
        "avatar_show"=> true,
        // 昵称字段是否使用
        "nickname_show"=> true,
        // 二级密码(支付密码)字段是否使用
        "laval_password_show"=> true,
        // 推荐人关系字段是否使用
        "parent_show"=> true,
        // 会员资产
        // 字段=> 字段注释
        "user_funds"=> [
            'money'=> '余额',
        ],
        // 会员资产的操作类型
        // 用于后台的会员资产流水记录条件筛选使用
        // 需要是使用以下示例的格式配置，否则筛选无法生效
        // 例：
        //      '数据库存储的值'=> '页面展示的值'
        //      'recharge'=> '充值'
        "fund_type"=> [
            '充值'=> '充值',
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | 文章相关设置
    |--------------------------------------------------------------------------
    */
    "article"=> [
        // 文章分类中的图片字段是否使用
        'category_image_show'=> false,
        // 文章标签中的图片字段是否使用
        'tag_image_show'=> false,
        // 标签字段是否使用
        'tag_show'=> true,
        // 作者字段是否使用
        'author_show'=> true,
        // 简介字段是否使用
        'intro_show'=> true,
        // 关键字字段是否使用
        'keyword_show'=> true,
        // 图片字段是否使用
        'image_show'=> true
    ],
    /*
    |--------------------------------------------------------------------------
    | 轮播图相关设置
    |--------------------------------------------------------------------------
    */
    'banner'=> [
        // 链接字段是否使用
        'url_show'=> true,
    ],
    /*
    |--------------------------------------------------------------------------
    | 系统设置相关
    |--------------------------------------------------------------------------
    */
    'setting'=> [
        // 行内工具栏是否展示
        // 用于开发是增加、删除、修改系统设置项
        // 此选项与环境配置同步
        'line_button_show'=> env('APP_DEBUG', true),
    ],
    /*
    |--------------------------------------------------------------------------
    | 公告相关配置
    |--------------------------------------------------------------------------
    */
    "notice"=> [
        // 图片字段是否展示
        'image_show'=> true,
        // 项目中公告的类型，可选项有：
        //     单条文字:   一般用于首页轮播图下滚动播出的文字公告的使用场景
        //     单条富文本: 一般用于首页弹出公告详情页面的使用场景
        //     多条富文本: 一般用于有公告列表，类似文章功能的使用场景
        'type'=> '多条富文本',
    ],
    /*
    |--------------------------------------------------------------------------
    | 系统消息相关配置
    |--------------------------------------------------------------------------
    */
    "sys_message"=> [
        // 图片字段是否展示
        'image_show'=> false,
        // 详情(富文本)字段是否展示
        'content_show'=> false,
        // 列表已读，如果设置为true，则获取系统消息列表后就将列表中的消息设置为已读
        // 如果设置为false，则在获取系统消息详情时将此消息设置为已读
        'list_read'=> true,
    ],
];
