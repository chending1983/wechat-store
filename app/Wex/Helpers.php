<?php
// 如：db:seed 或者 清空数据库命令的地方调用
function insanity_check()
{
    if (App::environment('production')) {
        exit('别傻了? 这是线上环境呀。');
    }
}

function qiniu_cdn($filepath)
{
    return config('app.qiniu_static') . $filepath;
}

function cdn($filepath)
{
    if (config('app.url_static')) {
        return config('app.url_static') . $filepath;
    } else {
        return config('app.url') . $filepath;
    }
}

function get_cdn_domain()
{
    return config('app.url_static') ?: config('app.url');
}

function get_user_static_domain()
{
    return config('app.user_static') ?: config('app.url');
}

function lang($text, $parameters = [])
{
    return str_replace('wewx.', '', trans('wewx.'.$text, $parameters));
}

function admin_link($title, $path, $id = '')
{
    return '<a href="'.admin_url($path, $id).'" target="_blank">' . $title . '</a>';
}

function admin_url($path, $id = '')
{
    return env('APP_URL') . "/admin/$path" . ($id ? '/'.$id : '');
}

function admin_enum_style_output($value, $reverse = false)
{
    if ($reverse) {
        $class = ($value === true || $value == 'yes') ? 'danger' : 'success';
    } else {
        $class = ($value === true || $value == 'yes') ? 'success' : 'danger';
    }

    return '<span class="label bg-'.$class.'">'.$value.'</span>';
}

function navViewActive($anchor)
{
    return Route::currentRouteName() == $anchor ? 'active' : '';
}

function model_link($title, $model, $id)
{
    return '<a href="'.model_url($model, $id).'" target="_blank">' . $title . '</a>';
}

function model_url($model, $id)
{
    return env('APP_URL') . "/$model/$id";
}

function per_page($default = null)
{
    $max_per_page = config('api.max_per_page');
    $per_page = (Input::get('per_page') ?: $default) ?: config('api.default_per_page');

    return (int) ($per_page < $max_per_page ? $per_page : $max_per_page);
}

/**
 * 生成用户客户端 URL Schema 技术的链接.
 */
function schema_url($path, $parameters = [])
{
    $query = empty($parameters) ? '' : '?'.http_build_query($parameters);

    return strtolower(config('app.name')).'://'.trim($path, '/').$query;
}

// formartted Illuminate\Support\MessageBag
function output_msb(\Illuminate\Support\MessageBag $messageBag){
    return implode(", ", $messageBag->all());
}

function get_platform(){
    return Request::header('X-Client-Platform');
}

function is_request_from_api()
{
    return $_SERVER['SERVER_NAME'] == env('API_DOMAIN');
}

function gen_uploadfiy($id, $multiple = 'true')
{
    $html = <<<EOT
        <div class="{$id}-upload-wrapper">
            <div id="{$id}-queue"></div>
            <input id="{$id}-upload" name="files" type="file" multiple="{$multiple}">
            <a style="position: relative; top: 8px; display: none" href="javascript:$('#file_upload').uploadifive('upload')"></a>
            
            <div class="upload-image"></div> 
            
            <div class="clearfix"></div>
        </div>
EOT;

    return $html;

}

function gen_nodata($msg = '服务器君什么都没找到', $showIndexLink = true)
{
    $html = <<<EOT
    <div class="nothing">
        <h3>%>_<%</h3>
        <p>{$msg}</p>
EOT;

    if($showIndexLink) {
        $html .= '<p><a href="{{ route(\'index\') }}">回首页</a></p>';
    }

    $html .= '
        </div>
    ';

    return $html;
}

function isSpider()
{
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'spider') || strpos($_SERVER['HTTP_USER_AGENT'], 'bot')) {
        return true;
    }

    return false;
}

function getTa($userId, $curUserId)
{
    if(isMe($userId, $curUserId)) {
        return '我';
    } else {
        return 'Ta';
    }
}

function isMe($userId, $curUserId)
{
    if($userId == $curUserId) {
        return true;
    } else {
        return false;
    }
}