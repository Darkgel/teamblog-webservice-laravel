<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:00
 */

namespace Enum;

final class HttpCode {
    const HTTP_CODE_CONTINUE = 100;
    const HTTP_CODE_SWITCHING_PROTOCOLS = 101;
    const HTTP_CODE_PROCESSING = 102;            // RFC2518
    const HTTP_CODE_EARLY_HINTS = 103;           // RFC8297
    const HTTP_CODE_OK = 200;                    //服务器成功返回用户请求的数据，该操作是幂等的（Idempotent)
    const HTTP_CODE_CREATED = 201;               //用户新建或修改数据成功
    const HTTP_CODE_ACCEPTED = 202;
    const HTTP_CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_CODE_NO_CONTENT = 204;            //用户删除数据成功或没有内容需要响应的
    const HTTP_CODE_RESET_CONTENT = 205;
    const HTTP_CODE_PARTIAL_CONTENT = 206;
    const HTTP_CODE_MULTI_STATUS = 207;          // RFC4918
    const HTTP_CODE_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_CODE_IM_USED = 226;               // RFC3229
    const HTTP_CODE_MULTIPLE_CHOICES = 300;
    const HTTP_CODE_MOVED_PERMANENTLY = 301;     //资源已经移动到其他位置
    const HTTP_CODE_FOUND = 302;
    const HTTP_CODE_SEE_OTHER = 303;
    const HTTP_CODE_NOT_MODIFIED = 304;
    const HTTP_CODE_USE_PROXY = 305;
    const HTTP_CODE_RESERVED = 306;
    const HTTP_CODE_TEMPORARY_REDIRECT = 307;
    const HTTP_CODE_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_CODE_BAD_REQUEST = 400;           //用户发出的请求有错误，服务器没有进行新建或修改数据的操作，该操作是幂等的
    const HTTP_CODE_UNAUTHORIZED = 401;          //表示用户没有权限（令牌、用户名、密码错误）
    const HTTP_CODE_PAYMENT_REQUIRED = 402;
    const HTTP_CODE_FORBIDDEN = 403;             //表示用户得到授权（与401错误相对），但是访问是被禁止的
    const HTTP_CODE_NOT_FOUND = 404;             //用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的
    const HTTP_CODE_METHOD_NOT_ALLOWED = 405;    //不允许访问的
    const HTTP_CODE_NOT_ACCEPTABLE = 406;        //用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）
    const HTTP_CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_CODE_REQUEST_TIMEOUT = 408;       //请求超时
    const HTTP_CODE_CONFLICT = 409;
    const HTTP_CODE_GONE = 410;                  //用户请求的资源被永久删除，且不会再得到的
    const HTTP_CODE_LENGTH_REQUIRED = 411;
    const HTTP_CODE_PRECONDITION_FAILED = 412;
    const HTTP_CODE_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_CODE_REQUEST_URI_TOO_LONG = 414;
    const HTTP_CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_CODE_EXPECTATION_FAILED = 417;
    const HTTP_CODE_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_CODE_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const HTTP_CODE_UNPROCESSABLE_ENTITY = 422;                                        //当创建一个对象时，发生一个验证错误/不能处理的错误
    const HTTP_CODE_LOCKED = 423;                                                      // RFC4918
    const HTTP_CODE_FAILED_DEPENDENCY = 424;                                           // RFC4918

    /**
     * @deprecated
     */
    const HTTP_CODE_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_CODE_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const HTTP_CODE_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_CODE_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_CODE_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_CODE_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_CODE_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;                                       //服务器发生错误，用户将无法判断发出的请求是否成功
    const HTTP_CODE_NOT_IMPLEMENTED = 501;                                             //未实现
    const HTTP_CODE_BAD_GATEWAY = 502;                                                 //错误的网关
    const HTTP_CODE_SERVICE_UNAVAILABLE = 503;                                         //服务不可用
    const HTTP_CODE_GATEWAY_TIMEOUT = 504;//网关超时
    const HTTP_CODE_VERSION_NOT_SUPPORTED = 505;//Http版本不支持
    const HTTP_CODE_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_CODE_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_CODE_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_CODE_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_CODE_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    /**
     * Status codes translation table.
     *
     * The list of codes is complete according to the
     * {@link http://www.iana.org/assignments/http-status-codes/ Hypertext Transfer Protocol (HTTP) Status Code Registry}
     * (last updated 2016-03-01).
     *
     * Unless otherwise noted, the status code is defined in RFC2616.
     *
     * @var array
     */
    public static $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    );
}
