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

$sites[] = array(
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

?>
