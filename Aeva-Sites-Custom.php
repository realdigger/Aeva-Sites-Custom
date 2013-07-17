<?php
/********************************************************************************
 * Aeva-Sites-Custom.php
 * By Rene-Gilles Deberdt
 *********************************************************************************
 * This program is distributed in the hope that it is and will be useful, but
 * WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.
 ********************************************************************************/

// Prevent attempts to access this file directly
if (!defined('SMF'))
    die('Hacking attempt...');

global $sites;

/* -- NEW CUSTOM SITES -- */
// vk.com
$sites[] = array(
    // http://vk.com/video98959839_162198496
    // http://vk.com/video3243223_162783355?d=1&t=27
    'id' => 'vk',
    'title' => 'VKontakte video',
    'website' => 'http://vk.com',
    'type' => 'custom',
    'plugin' => 'html',
    'pattern' => 'http://(?:www\.)?vk(?:ontakte\.ru|\.com)/(?:.+=)?video([0-9\-]+)_([0-9]+)[^:\s#]*#hash([a-zA-Z0-9]+)',
    'movie' => '<div style="margin-top: 15px;"><iframe src="http://vk.com/video_ext.php?oid=$2&id=$3&hash=$4" width="{int:width}" height="{int:height}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>',
    'size' => array(607, 360),
    'show-link' => true,
    'fix-html-pattern' => '<iframe\s+src="http://(?:www\.)?vk(?:ontakte\.ru|\.com)/video_ext.php\?oid=([0-9\-]+)&id=([0-9]+)[^>]*>[^>]*</iframe>',
    'fix-html-url' => 'http://vk.com/video$1_$2',
    //'lookup-title' => '\\\\\\"md_title\\\\\\":\\\\\\"(.+)\\\\\\",\\\\\\"md_author\\\\\\"',
    'lookup-title-skip' => true,
    'lookup-url' => 'http://(?:www\.)?vk(?:ontakte\.ru|\.com)/(?:.+=)?video([0-9\-]+)_([0-9]+)[^:\s#]*',
    'lookup-pattern' => array('hash' => '\\\\\\"hash2\\\\\\":\\\\\\"([a-zA-Z0-9]+)\\\\\\"'),
    'lookup-skip-empty' => true,
);
// vesti.ru
$sites[] = array(
    // http://www.vesti.ru/videos?vid=522693&cid=1
    'id' => 'vst',
    'title' => 'Vesti.ru',
    'website' => 'http://www.vesti.ru',
    'type' => 'custom',
    'added' => '5.2',
    'pattern' => 'http://(?:www\.)?vesti\.ru/(?:videos\?vid=)(\d+)',
    'movie' => 'http://www.vesti.ru/i/flvplayer_videoHost.swf?vid=$2&fbv=true&isHome=false',
    'size' => array(408, 356),
    'show-link' => true,
    'lookup-title' => true,
    'fix-html-pattern' => '<object [^>]*><param name=movie value="$1">.*?</object>',
    'fix-html-url' => 'http://www.vesti.ru/videos?vid=$2'
);
// rpod.ru
$sites[] = array(
    // http://rpod.ru/305459
    // TODO: http://java-se.rpod.ru/305459.html
    'id' => 'rpod',
    'title' => 'Rpod.ru',
    'website' => 'http://rpod.ru',
    'type' => 'custom',
    'pattern' => 'http://(?:www\.)?rpod\.ru/(\d+)#id(\d+)',
    'movie' => 'http://s.rpod.ru/swf/playa.swf?xmlURL=http%3A%2F%2Fs.rpod.ru%2Fxml%2Fvideo%2Fa$3.xml',
    'size' => array(500, 400),
    'lookup-title' => true,
    'lookup-url' => 'http://(?:www\.)?rpod\.ru/(\d+)',
    'lookup-pattern' => array('id' => 'rpod\.ru/get/\d+/(\d+)/flv'),
);

/* -- CUSTOM SETTINGS FOR EXISTING SITES -- */
foreach ($sites as $si => $te) {
    // Fix for vimeo.com
    if ($te['id'] == 'vimeo') {
        // http://vimeo.com/69277800
        // http://player.vimeo.com/video/69277800
        // http://vimeo.com/channels/staffpicks/69208253
        // http://vimeo.com/ondemand/somegirls/69277800
        // http://vimeo.com/groups/musicvideo/videos/68422599
        $sites[$si]['pattern'] = 'http://(?:www\.|player\.)?vimeo\.com/(?:video/|channels/[A-Za-z0-9_-]+/|ondemand/[A-Za-z0-9_-]+/|groups/[A-Za-z0-9_-]+/videos/)?(\d{1,12})';
        $sites[$si]['movie'] = 'http://vimeo.com/moogaloop.swf?clip_id=$2&server=vimeo.com&fullscreen=1&show_title=1&show_byline=1&show_portrait=0&color=01AAEA';
    }
    // Fix for video.yandex.ru
    if ($te['id'] == 'yax') {
        // http://video.yandex.ru/users/pugachev-alexander/view/8866/
        // TODO: http://video.yandex.ru/users/sergevz/view/484/?cauthor=ruzlena&cid=3#
        $sites[$si]['website'] = 'http://video.yandex.ru';
        $sites[$si]['pattern'] = '(?:http://flv\.video\.yandex\.ru/lite/([\w-]+)/(\w+\.\d+)|http://video\.yandex\.ru/users/([\w-]+)/view/\d+/?#id(\w+\.\d+))';
        $sites[$si]['movie'] = 'http://static.video.yandex.ru/lite/$2$4/$3$5';
        $sites[$si]['fix-html-pattern'] = '(?:<object width="(\d+)" height="(\d+)"><param name="video" value="http://flv\.video\.yandex\.ru/lite/([\w-]+)/(\w+\.\d+)/">.*?</object>)';
        $sites[$si]['fix-html-url'] = 'http://static.video.yandex.ru/lite/$3/$4#w$1-h$2';
        $sites[$si]['lookup-url'] = 'http://video\.yandex\.ru/users/[\w-]+/view/\d+/?';
        $sites[$si]['lookup-pattern'] = array(
            'id' => '\[flash=\d+,\d+,http://static\.video\.yandex\.ru/lite/[\w-]+/(\w+\.\d+)/]',
            'w' => '\[flash=(d+),d+,',
            'h' => '\[flash=d+,(d+),');
        $sites[$si]['lookup-title'] = true;
    }
    // Fix for rutube.ru
    if ($te['id'] == 'rut') {
        // http://rutube.ru/video/2f44d7dd01eacf0fc15f1eb0156cb877/?bmstart=1591
        // http://rutube.ru/video/2f44d7dd01eacf0fc15f1eb0156cb877
        // TODO: http://rutube.ru/tracks/1869729.html?v=b772eac9a287fb0494eda
        // TODO: http://rutube.ru/video/embed/6433492?wmode=direct
        $sites[$si]['plugin'] = 'html';
        $sites[$si]['pattern'] = 'http://(?:www\.)?rutube\.ru/video/([0-9a-f]{32})*#id(\d+)';
        $sites[$si]['movie'] = '<div style="margin-top: 15px;"><iframe width="470" height="353" src="http://rutube.ru/video/embed/$3" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe></div>';
        $sites[$si]['lookup-url'] = 'http://(?:www\.)?rutube\.ru/video/([0-9a-f]{32})';
        $sites[$si]['lookup-pattern'] = array('id' => 'video/embed/(\d+)"');
        $sites[$si]['lookup-title'] = true;
    }
    if ($te['id'] == 'smo') {
        // http://smotri.com/video/view/?id=v24802498bff
        $sites[$si]['pattern'] = 'http://(?:www\.)?smotri\.com/video/view/\?id=v([0-9a-f]{10,})';
        $sites[$si]['movie'] = 'http://pics.smotri.com/player.swf?file=v$2&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml';
        $sites[$si]['lookup-title'] = true;
    }
}
?>