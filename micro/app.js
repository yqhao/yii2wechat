const openIdUrl = require('./config').openIdUrl
const config = require('./config.js');
var encoding = require('./vendor/encoding/sha1.js');
var wxApi = require('./util/wxApi')
var wxRequest = require('./util/wxRequest')
var util = require('./util/util');
var feedbackApi = require('./vendor/feedBack/showToast');//引入消息提醒暴露的接口  

App({
  onLaunch: function () {
    wx.setEnableDebug({
      enableDebug: false
    })
    console.log('App Launch');
    this.globalData.config = config;

    this.globalData.siteBaseUrl = config.siteBaseUrl;
  },
  onShow: function () {
    console.log('App Show')
    
  },
  onHide: function () {
    console.log('App Hide')
  },
  globalData: {
    hasLogin: false,
    openid: null,
    config: null,
    appId: null,
    token_key: null,
    auth_key:null,
    userInfo:null,
    siteBaseUrl:null,
    tabBarPagePathArr:'["/page/pages/index/index"]'
  },
  // lazy loading openid
  getUserOpenId: function(callback) {
    var self = this

    if (self.globalData.openid) {
      callback(null, self.globalData.openid)
    } else {
      wx.login({
        success: function(data) {
          wx.request({
            url: openIdUrl,
            data: {
              code: data.code
            },
            success: function(res) {
              console.log('拉取openid成功', res)
              self.globalData.openid = res.data.openid
              callback(null, self.globalData.openid)
            },
            fail: function(res) {
              console.log('拉取用户openid失败，将无法正常使用开放接口等服务', res)
              callback(res)
            }
          })
        },
        fail: function(err) {
          console.log('wx.login 接口调用失败，将无法正常使用开放接口等服务', err)
          callback(err)
        }
      })
    }
  },

  // 获取系统信息
  getSystemInfo: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res) {
        that.systemInfo = res;
      }
    });
  },
  // 获取页面信息
  getCurrentPagesFormat: function () {
    var pages = getCurrentPages();;
    return pages[pages.length - 1];
  },
  // 发送请求
  // param 参数, customSiteUrl 自定义域名
  /* param:
  data:{app_id,_app_id,session_key}
  header: {},
  url: "",
  method: "",
  hideLoading: bool,
  success: function (res.data) { },
  fail: function (res.data) { },
  complete: function (res.data) { }
  */
  sendRequest: function (param, customSiteUrl) {
    var that = this,
      data = param.data || {},
      header = param.header,
      requestUrl;

    if (data.app_id) {
      data._app_id = data.app_id;
    } else {
      data._app_id = data.app_id = this.getAppId();
    }
    // data._app_id = this.getAppId();
    // data.app_id = this.getAppId();
    // if (!this.globalData.notBindXcxAppId) {
    //   data.session_key = this.getSessionKey();
    // }

    // 组装请求地址
    if (customSiteUrl) {
      requestUrl = customSiteUrl + param.url;
    } else {
      requestUrl = this.globalData.siteBaseUrl + param.url;
    }
    // POST请求模式
    if (param.method) {
      if (param.method.toLowerCase() == 'post') {
        data = this.modifyPostParam(data);
        header = header || {
          'content-type': 'application/x-www-form-urlencoded;',
          'Authorization': 'Bearer ' + that.getTokenKey(),
          'Auth-Key': that.getAuthKey(),
        }
      }
      param.method = param.method.toUpperCase();
    }
    console.log(requestUrl);
    console.log('---header---');
    console.log(header);
    console.log('---params---');
    console.log(data);
    if (!param.hideLoading) {
      this.showToast({
        title: '请求中...',
        icon: 'loading'
      });
    }
    //console.log('---customSiteUrl ' + customSiteUrl+' url '+ param.url);
    // 请求
    wx.request({
      url: requestUrl,
      data: data,
      method: param.method || 'GET',
      header: header || {
        'content-type': 'application/json'
      },
      success: function (res) {
        // console.log('----请求失败success');
        if (res.statusCode == undefined || res.statusCode != 200) {

          that.hideToast();

          if (res.data.status) {
            // if (res.data.status == 401 || res.data.status == 2) {
            //   // 未登录
            //   that.login();
            //   return;
            // }
            if (res.data.status != 1) {
              that.showModal({
                content: '' + res.data.message
              });
              return;
            }
          }

          
          that.showModal({
            content: '' + res.message
          });
          // console.log('----request error-----');
          // console.log(res);
          return;
        }
        
        //console.log(requestUrl);
        //console.log(res.data); console.log(data);
        typeof param.success == 'function' && param.success(res.data);
      },
      fail: function (res) {
        that.showModal({
          content: '请求失败 ' + res.errMsg
        })
        typeof param.fail == 'function' && param.fail(res.data);
      },
      complete: function (res) {
        // wx.hideLoading();
        that.hideToast();
        typeof param.complete == 'function' && param.complete(res.data);
      }
    });
  },
  modifyPostParam: function (obj) {
    let query = '',
      name, value, fullSubName, subName, subValue, innerObj, i;

    for (name in obj) {
      value = obj[name];

      if (value instanceof Array) {
        for (i = 0; i < value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += this.modifyPostParam(innerObj) + '&';
        }
      }
      else if (value instanceof Object) {
        for (subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += this.modifyPostParam(innerObj) + '&';
        }
      }
      else if (value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }

    return query.length ? query.substr(0, query.length - 1) : query;
  },

  // 动态设置当前页面的标题。
  setPageTitle: function (title) {
    wx.setNavigationBarTitle({
      title: title
    });
  },
  // 显示消息提示框
  showToast: function (param) {
    wx.showToast({
      title: param.title,
      icon: param.icon,
      duration: param.duration || 1500,
      success: function (res) {
        typeof param.success == 'function' && param.success(res);
      },
      fail: function (res) {
        typeof param.fail == 'function' && param.fail(res);
      },
      complete: function (res) {
        typeof param.complete == 'function' && param.complete(res);
      }
    })
  },
  // 隐藏消息提示框
  hideToast: function () {
    wx.hideToast();
  },
  // 显示模态弹窗
  showModal: function (param) {
    wx.showModal({
      title: param.title || '提示',
      content: param.content,
      showCancel: param.showCancel || false,
      cancelText: param.cancelText || '取消',
      cancelColor: param.cancelColor || '#000000',
      confirmText: param.confirmText || '确定',
      confirmColor: param.confirmColor || '#3CC51F',
      success: function (res) {
        if (res.confirm) {
          typeof param.confirm == 'function' && param.confirm(res);
        } else {
          typeof param.cancel == 'function' && param.cancel(res);
        }
      },
      fail: function (res) {
        typeof param.fail == 'function' && param.fail(res);
      },
      complete: function (res) {
        typeof param.complete == 'function' && param.complete(res);
      }
    })
  },
  getSiteBaseUrl: function () {
    return this.globalData.siteBaseUrl;
  },
  getAppId: function () {
    return this.globalData.appId;
  },
  // getSessionKey: function () {
  //   return this.globalData.sessionKey;
  // },
  // setSessionKey: function (session_key) {
  //   this.globalData.sessionKey = session_key;
  //   wx.setStorage({
  //     key: 'session_key',
  //     data: session_key
  //   })
  // },
  // 跳转到 tabBar 页面
  switchToTab: function (url) {
    wx.switchTab({
      url: url
    });
  },
  // 页面跳转
  turnToPage: function (url, isRedirect) {
    var tabBarPagePathArr = this.getTabPagePathArr();//tabBar页面数组对象
    // tabBar中的页面改用switchTab跳转
    if (tabBarPagePathArr.indexOf(url) != -1) {
      this.switchToTab(url);
      return;
    }
    if (!isRedirect) {
      wx.navigateTo({
        url: url
      });
    } else {
      wx.redirectTo({
        url: url
      });
    }
  },
  getTabPagePathArr: function () {
    return JSON.parse(this.globalData.tabBarPagePathArr);
  },
  
  // 0.check login
  checkLoginBackend:function(){
    let token = this.getTokenKey();
    if (token) {
      this.checkTokenKey(token);//验证登录token
    } else {
      this.syncLogin();
    }
  },
  getTokenKey: function () {
    let token_key = null;
    if (this.globalData.token_key){
      token_key = this.globalData.token_key;
    }else{
      let key = wx.getStorageSync('token_key');
      if (key) {
        token_key = key;
        this.globalData.token_key = token_key;
      }
      // else{
      //   this.syncLogin();
      //   return;
      // }
    }
    return token_key;
  },
  saveTokenKey: function (token_key) {
    console.log('---save token_key:' + token_key);
    this.globalData.token_key = token_key;
    wx.setStorage({
      key: 'token_key',
      data: token_key
    })
  },

  getAuthKey: function () {
    let auth_key = null;
    if (this.globalData.auth_key) {
      auth_key = this.globalData.auth_key;
    } else {
      let key = wx.getStorageSync('auth_key');
      if (key) {
        auth_key = key;
        this.globalData.auth_key = auth_key;
      }
    }
    return auth_key;
  },
  saveAuthKey:function(data){
    let auth_key = null;
    if (data != null){
      let arr = new Array(data.token, data.auth_key);
      // 升序
      arr.sort(function (a, b) { return a > b ? 1 : -1 });
      auth_key = encoding.hex_sha1(arr[0] + arr[1]);
    }
    this.globalData.auth_key = auth_key;
    wx.setStorage({
      key: 'auth_key',
      data: auth_key
    })
  },

  /**
   * 发送token
   */
  checkTokenKey: function (token) {
    var that = this;
    this.sendRequest({
      url: '/api/v1/user-auth/check-login',
      data: { token: token},
      method: 'post',
      success: function (res) {
        if (res.status != 1) {
          console.log('--重新登录--');
          that.syncLogin();
        }
        let userInfo = that.getUserInfo();
        if(userInfo == null){
          that.requestUserInfoWx();
        }
      },
      fail: function (res) {
        console.log('sendTokenKey fail');
      }
    });
    
  },
  // 向服务器发送微信登录返回的code
  sendCode: function (code) {
    var that = this;
    this.sendRequest({
      url: '/api/v1/user-auth/send-code',
      method: 'post',
      data: {
        code: code
      },
      success: function (res) {
        that.saveTokenKey(res.data.token);
        that.saveAuthKey(res.data);
        //that.requestUserInfo(0);
        // save user info local and backend
        that.pageInitial();
      },
      fail: function (res) {
        console.log('sendCode fail');
      },
      complete: function (res) {
        console.log(res);
      }
    })
  },

  requestUserInfo: function (info_type) {
    // if (info_type == 1) {
    //   this.requestUserInfoBackend();
    // } else {
    //   this.requestUserInfoWx();
    // }
  },
  // 获取小程序后台会员信息
  requestUserInfoBackend: function () {
    var that = this;
    this.sendRequest({
      url: '/index.php?r=AppData/getXcxUserInfo',
      success: function (res) {
        if (res.status == 0) {
          if (res.data) {
            that.setUserInfoStorage(res.data);
          }
        }
      },
      fail: function (res) {
        console.log('requestUserXcxInfo fail');
      }
    })
  },
  // 获取微信用户信息
  requestUserInfoWx: function () {
    var that = this;
    wx.getUserInfo({
      success: function (res) {
        console.log('requestUserWxInfo');
        console.log(res);
        // var times = setInterval(function () { 
        //   let token = that.getTokenKey();
        //   if (token){
            that.sendUserInfo(res.userInfo);
          // }
          // clearTimeout(times); 
        
        // });
      },
      fail: function (res) {
        console.log('requestUserWxInfo fail');
      },
      complete: function (res) {
        console.log(res);
      }
    })
  },

  login: function () {
    var that = this;
    that.saveTokenKey(null);
    that.saveAuthKey(null);
    wx.login({
      success: function (res) {
        console.log('----login---'); 
        console.log(res); 
        // return;
        
        if (res.code) {
          that.sendCode(res.code);//后台登录
          that.requestUserInfoWx();
        } else {
          console.log('获取用户登录态失败！' + res.errMsg)
        }
      },
      fail: function (res) {
        console.log('login fail: ' + res.errMsg);
      }
    })
  },

  pageInitial: function () {
    return;
  },
//********************************************************/
//********************************************************/
//********************************************************/




  getUserInfo: function () {
    let userInfo = null;
    if (this.globalData.userInfo){
      userInfo = this.globalData.userInfo;
    }else{
      let value = wx.getStorageSync('userInfo');
      if (value) {
        userInfo = value;
        this.globalData.userInfo = userInfo;
      }
    }
    return userInfo;
  },
  setUserInfoStorage: function (info) {
    // console.log('setInfoStorage');
    // console.log(info);
    // for (var key in info) {
    //   console.log(key+' -- ' + info[key]);
    //   this.globalData.userInfo[key] = info[key];
    // }
    this.globalData.userInfo = info;
    wx.setStorage({
      key: 'userInfo',
      data: this.globalData.userInfo
    })
  },

  
  // 向后台发送用户信息
  sendUserInfo: function (userInfo) {
    // console.log('屏蔽登录接口');
    // return;
    var that = this;
    this.sendRequest({
      url: '/api/v1/user-info/save',
      method: 'post',
      data: {
        user_info: JSON.stringify({
          nickname: userInfo['nickName'],
          gender: userInfo['gender'],
          city: userInfo['city'],
          province: userInfo['province'],
          country: userInfo['country'],
          avatarUrl: userInfo['avatarUrl']
        })
      },
      success: function (res) {
        if (res.status == 1) {
          that.setUserInfoStorage(res.data.user_info);
        }
      },
      fail: function (res) {
        console.log('requestUserXcxInfo fail');
      }
    })
  },
  



  // 同步登陆
  syncLogin:function(){
    let step=0;
    var that = this;
    
    var requestUrl = that.globalData.siteBaseUrl;
    wx.showToast({
      title: '加载中',
      icon: 'loading',
      duration: 10000
    })
    //1.获取code
    var wxLogin = wxApi.wxLogin();
    wxLogin().
      then(res => {
        console.log('1.get code 成功')
        //console.log(res.code)
        var url = requestUrl +'/api/v1/user-auth/send-code';
        var params = util.json2Form({ code: res.code });

        //2.获取send code get token
        step = 1;
        return wxRequest.postRequest(url, params);
      }).
      then(res => {
        console.log('2.send code get token 成功');
        console.log(res);
        if (res.statusCode != 200){
          console.log(res.statusCode);
          that.toast({
            title: res.data.message != undefined ? res.data.message : '未知错误', 
            duration: 3000, 
            cb: function () {
              that.turnToPage('/page/pages/index/index', true);
            }
          });
          return false;
        }

        that.saveTokenKey(res.data.data.token);
        //console.log('2.成功save')
        that.saveAuthKey(res.data.data);
        //console.log('2.成功save')
        //3.获取用户信息
        var wxGetUserInfo = wxApi.wxGetUserInfo();
        //console.log(wxGetUserInfo)
        step = 2;
        return wxGetUserInfo();
      }).
      then(res => {
        console.log('3.wxGetUserInfo 成功')
        //console.log(res.userInfo)

        that.setUserInfoStorage(res.userInfo);

        var date = new Date();
        var dateNow = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

        var url = requestUrl + '/api/v1/user-info/save';
        var params = {
          user_info: JSON.stringify({
            nickName: res.userInfo['nickName'],
            gender: res.userInfo['gender'],
            city: res.userInfo['city'],
            province: res.userInfo['province'],
            country: res.userInfo['country'],
            avatarUrl: res.userInfo['avatarUrl'],
            updateDate: dateNow
          })
        };

        //console.log(params)
        let header = {
          'content-type': 'application/x-www-form-urlencoded;',
          'Authorization': 'Bearer ' + that.getTokenKey(),
          'Auth-Key': that.getAuthKey(),
        };
        step = 3;
        return wxRequest.postRequest(url, params, header);
      })
      .then(res => {
        console.log('4.send user info 成功')
        //console.log(res)
        //wxApi.wxNavigateTo('/page/pages/userCenter/userCenter');
        if (res.statusCode != 200) {
          console.log(res.statusCode);
          that.toast({
            title: res.data.message != undefined ? res.data.message : '未知错误',
            duration: 3000,
            cb: function () {
              that.turnToPage('/page/pages/index/index', true);
            }
          });
          return false;
        }
        
        let userInfo = that.getUserInfo();
        var currentPage = that.getCurrentPagesFormat();
        currentPage.setData({ 'userInfo': userInfo });

        console.log('--user info--');
        console.log(userInfo);
        step = 4;
        return true;
      }).
      finally(function (res) {
        console.log('finally~')
        console.log(res)
        wx.hideToast()
        console.log('step = ' + step);
      });
  },

  // syncCheckLogin:function(){
  //   var that = this;

  //   var requestUrl = that.globalData.siteBaseUrl;
  //   wx.showToast({
  //     title: '加载中',
  //     icon: 'loading',
  //     duration: 10000
  //   })
  //   //1.获取code
  //   var postRequest = wxRequest.postRequest();
  //   postRequest().
  //     then(res => {

  //       let token = this.getTokenKey();
  //       if (token) {
  //         this.checkTokenKey(token);//验证登录token
  //       } else {
  //         this.syncLogin();
  //       }


  //       console.log('1.get code 成功')
  //       //console.log(res.code)
  //       var url = requestUrl + '/api/v1/user-auth/send-code';
  //       var params = util.json2Form({ code: res.code });

  //       //2.获取send code get token
  //       return wxRequest.postRequest(url, params)
  //     }).
  //     finally(function (res) {
  //     console.log('finally~')
  //     console.log(res)
  //     wx.hideToast()
  //   });
  // },
  toast:function(params){
    feedbackApi.showToast(params);
  },
  modelShow: function (params) {
    feedbackApi.showModel(params);
  },
  modelHide: function () {
    feedbackApi.hideModel();
  },
})
