/**
 * 小程序配置文件
 */

// 此处主机域名是腾讯云解决方案分配的域名
// 小程序后台服务解决方案：https://www.qcloud.com/solution/la

var env = 'pro';
var api_host = "api.ausnowtravel.shop";
var config = {
    api_host,
    indexAdUrl: `https://${api_host}/api/v1/widget-carousel?expand=items`,
    siteBaseUrl: `https://${api_host}`,
};

if (env == 'dev') {
  //var api_host = "api.weapp.dev";
  var api_host = "api.wechat.dev";

  var config = {
    api_host,
    indexAdUrl: `http://${api_host}/api/v1/widget-carousel?expand=items`,
    siteBaseUrl: `http://${api_host}`,
  };
}

module.exports = config
