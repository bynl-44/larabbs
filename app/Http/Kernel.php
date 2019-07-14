<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\RecordLastActivedTime;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    /**
     * 全局中间件
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        # 检查应用是否进入「维护模式」
        # 见：https://learnku.com/docs/laravel/5.7/configuration#maintenance-mode
        CheckForMaintenanceMode::class,

        # 检查表单请求的数据是否过大
        ValidatePostSize::class,

        # 对提交的请求参数进行 PHP 函数 trim() 处理
        TrimStrings::class,

        # 将提交的请求参数中空字串转换为 null
        ConvertEmptyStringsToNull::class,

        # 修正代理服务器后的服务器参数
        TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        // Web 中间件组，应用于 routes/web.php 路由文件，
        // 在 RouteServiceProvider 中设定
        'web' => [
            # cookie 加密解密
            EncryptCookies::class,

            # 将 cookie 添加到响应中
            AddQueuedCookiesToResponse::class,

            # 开启回话
            StartSession::class,

            // \Illuminate\Session\Middleware\AuthenticateSession::class,

            # 将系统的错误数据注入的视图变量 $errors 中
            ShareErrorsFromSession::class,

            # 检查 CSRF，防止跨站请求伪造的安全威胁
            VerifyCsrfToken::class,

            # 处理路由绑定
            SubstituteBindings::class,

            # 强制用户邮箱认证
            EnsureEmailIsVerified::class,

            # 记录用户最后活跃时间
            RecordLastActivedTime::class,
        ],

        # API 中间件组，应用于 routes/api.php 路由文件
        # 在 RouteServiceProvider 中设定
        'api' => [
            # 使用别名来调用中间件
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * 中间件别名设置，允许使用别名调用中间件，例如上面的 api 中间件组调用
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = array(
        # 只有登录用户才能访问，我们在控制器的构造方法中大量使用
        'auth' => Authenticate::class,

        # HTTP Basic Auth 认证
        'auth.basic' => AuthenticateWithBasicAuth::class,

        # 处理路由绑定
        'bindings' => SubstituteBindings::class,

        'cache.headers' => SetCacheHeaders::class,

        # 用户授权功能
        'can' => Authorize::class,

        # 只有游客才能访问，在 register 和 login 请求中使用，只有未登录用户才能访问这些页面
        'guest' => RedirectIfAuthenticated::class,

        # 签名认证，
        'signed' => ValidateSignature::class,

        # 访问节流，类似「1 分钟只能请求 10 次」的需求，一般在 api 中使用
        'throttle' => ThrottleRequests::class,

        # laravel 自带的强制用户邮箱认证中间件，为了更加贴近我们的逻辑，已经重写
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    );

    /**
     * 设定中间件优先级，此数组定义了除「全局中间件」以外的中间件执行顺序
     * 可以看到 StartSession 永远是最开始执行的，因为在 StartSession 之后，才能在应用中使用 Auth 等用户认证功能。
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
}
