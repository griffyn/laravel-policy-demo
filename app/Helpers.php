<?php
/**
 * Created by PhpStorm.
 * User: fengliang
 * Date: 2018/12/25
 * Time: 11:01
 */

use App\Models\User;

function convert2Uuid($str)
{
    if (strlen($str)!==32) {
        return '';
    }

    $uuidPattern = '/[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}/';
    if (preg_match($uuidPattern, $str)) {
        return $str;
    }

    $pattern = '/([A-Za-z0-9]{8})([A-Za-z0-9]{4})([A-Za-z0-9]{4})([A-Za-z0-9]{4})([A-Za-z0-9]{12})/';
    preg_match($pattern, $str, $matches);

    return $matches[1].'-'.$matches[2].'-'.$matches[3].'-'.$matches[4].'-'.$matches[5];
}

function isUuid($str)
{
    $pattern = '/[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}/';
    return preg_match($pattern, $str);
}

function uuid4()
{
    return (string) Ramsey\Uuid\Uuid::uuid4();
}

function asset_file_dir($filename)
{
    $prefixes = [
        substr($filename, 0, 1),
        substr($filename, 0, 2),
        substr($filename, 0, 4),
    ];

    return implode('/', $prefixes);
}

function getMimeTypeByFileExtension(String $extension)
{
    $types = array(
        'avi'     => 'video/x-msvideo',
        'bmp'     => 'image/bmp',
        'class'   => 'application/octet-stream',
        'css'     => 'text/css',
        'csv'     => 'text/csv',
        'dcr'     => 'application/x-director',
        'dir'     => 'application/x-director',
        'dll'     => 'application/octet-stream',
        'dmg'     => 'application/octet-stream',
        'dms'     => 'application/octet-stream',
        'doc'     => 'application/msword',
        'docx'     => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'etx'     => 'text/x-setext',
        'exe'     => 'application/octet-stream',
        'gif'     => 'image/gif',
        'htm'     => 'text/html',
        'html'    => 'text/html',
        'ico'     => 'image/x-icon',
        'jpeg'    => 'image/jpeg',
        'jpg'     => 'image/jpeg',
        'js'      => 'application/x-javascript',
        'json'    => 'application/json',
        'mov'     => 'video/quicktime',
        'movie'   => 'video/x-sgi-movie',
        'mp3'     => 'audio/mpeg',
        'mpeg'    => 'video/mpeg',
        'mpg'     => 'video/mpeg',
        'mpga'    => 'audio/mpeg',
        'pdf'     => 'application/pdf',
        'png'     => 'image/png',
        'ppt'     => 'application/vnd.ms-powerpoint',
        'pptx'     => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'rtf'     => 'text/rtf',
        'rtx'     => 'text/richtext',
        'sgm'     => 'text/sgml',
        'sgml'    => 'text/sgml',
        'sh'      => 'application/x-sh',
        'shar'    => 'application/x-shar',
        'silo'    => 'model/mesh',
        'sit'     => 'application/x-stuffit',
        'skd'     => 'application/x-koan',
        'skm'     => 'application/x-koan',
        'skp'     => 'application/x-koan',
        'skt'     => 'application/x-koan',
        'smi'     => 'application/smil',
        'smil'    => 'application/smil',
        'snd'     => 'audio/basic',
        'so'      => 'application/octet-stream',
        'spl'     => 'application/x-futuresplash',
        'src'     => 'application/x-wais-source',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc'  => 'application/x-sv4crc',
        'svg'     => 'image/svg+xml',
        'svgz'    => 'image/svg+xml',
        'swf'     => 'application/x-shockwave-flash',
        't'       => 'application/x-troff',
        'tar'     => 'application/x-tar',
        'tcl'     => 'application/x-tcl',
        'tex'     => 'application/x-tex',
        'texi'    => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif'     => 'image/tiff',
        'tiff'    => 'image/tiff',
        'tr'      => 'application/x-troff',
        'tsv'     => 'text/tab-separated-values',
        'txt'     => 'text/plain',
        'ustar'   => 'application/x-ustar',
        'vcd'     => 'application/x-cdlink',
        'vrml'    => 'model/vrml',
        'vxml'    => 'application/voicexml+xml',
        'wav'     => 'audio/x-wav',
        'wbmp'    => 'image/vnd.wap.wbmp',
        'wbxml'   => 'application/vnd.wap.wbxml',
        'wml'     => 'text/vnd.wap.wml',
        'wmlc'    => 'application/vnd.wap.wmlc',
        'wmls'    => 'text/vnd.wap.wmlscript',
        'wmlsc'   => 'application/vnd.wap.wmlscriptc',
        'wrl'     => 'model/vrml',
        'xbm'     => 'image/x-xbitmap',
        'xht'     => 'application/xhtml+xml',
        'xhtml'   => 'application/xhtml+xml',
        'xls'     => 'application/vnd.ms-excel',
        'xml'     => 'application/xml',
        'xpm'     => 'image/x-xpixmap',
        'xsl'     => 'application/xml',
        'xslx'     => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xslt'    => 'application/xslt+xml',
        'xul'     => 'application/vnd.mozilla.xul+xml',
        'xwd'     => 'image/x-xwindowdump',
        'xyz'     => 'chemical/x-xyz',
        'zip'     => 'application/zip'
    );

    return isset($types[strtolower($extension)])? $types[strtolower($extension)]:false;
}

function human2byte($value)
{
    return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
        switch (strtolower($m[2])) {
            case 't':
                $m[1] *= 1024;
                //不需要break
            case 'g':
                $m[1] *= 1024;
                //不需要break
            case 'm':
                $m[1] *= 1024;
                //不需要break
            case 'k':
                $m[1] *= 1024;
        }
        return $m[1];
    }, $value);
}
