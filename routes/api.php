<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'change-locale',],
], function ($api){
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api){
        # 游客可以访问的接口
        # 短信验证码
        $api->post('verificationCodes', 'VerificationCodesController@store')
            ->name('api.verificationCodes.store');
        # 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        # 图片验证码
        $api->post('captchas', 'CaptchasController@store')
            ->name('api.captchas.store');
        # 第三方登录
        $api->post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->name('api.socials.authorizations.store');
        # 登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        # 刷新 token
        $api->put('authorizations', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        # 删除 token
        $api->delete('authorizations', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
        # 分类列表
        $api->get('categories', 'CategoriesController@index')
            ->name('api.categories.index');
        # 话题列表
        $api->get('topics', 'TopicsController@index')
            ->name('api.topics.index');
        # 话题详情
        $api->get('topics/{topic}', 'TopicsController@show')
            ->name('api.topics.show');
        # 某用户的话题列表
        $api->get('users/{user}/topics', 'TopicsController@userIndex')
            ->name('api.users.topics.index');
        # 话题的回复列表
        $api->get('topics/{topic}/replies', 'RepliesController@index')
            ->name('api/topics.replies.index');
        # 某用户的回复列表
        $api->get('users/{user}/replies', 'RepliesController@userIndex')
            ->name('api.users.replies.index');
        # 资源推荐
        $api->get('links', 'LinksController@index')
            ->name('api.links.index');
        # 活跃用户
        $api->get('actived/users', 'UsersController@activedIndex')
            ->name('api.actived.user.index');

        # 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function ($api) {
            # 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            # 编辑登录用户信息
            $api->patch('user', 'UsersController@update')
                ->name('api.user.update');
            # 图片资源
            $api->post('images', 'ImagesController@store')
                ->name('api.images.store');
            # 发布话题
            $api->post('topics', 'TopicsController@store')
                ->name('api.topics.store');
            # 修改话题
            $api->patch('topics/{topic}', 'TopicsController@update')
                ->name('api.topics.update');
            # 删除话题
            $api->delete('topics/{topic}', 'TopicsController@destroy')
                ->name('api.topics.destroy');
            # 发布回复
            $api->post('topics/{topic}/replies', 'RepliesController@store')
                ->name('api.replies.store');
            # 删除回复
            $api->delete('topics/{topic}/replies/{reply}', 'RepliesController@destroy')
                ->name('api.topics.replies.destroy');
            # 用户通知列表
            $api->get('user/notifications', 'NotificationsController@index')
                ->name('api.user.notifications.index');
            # 用户通知统计
            $api->get('user/notifications/stats', 'NotificationsController@stats')
                ->name('api.user.notifications.stats');
            # 标记通知为已读
            $api->patch('user/read/notifications', 'NotificationsController@read')
                ->name('api.user.notifications.read');
            # 当前登录用户权限
            $api->get('user/permissions', 'PermissionsController@index')
                ->name('api.user.permissions.index');
        });
    });

});
