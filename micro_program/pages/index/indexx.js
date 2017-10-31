var appInstance = getApp();
var WxParse = require('../../components/wxParse/wxParse.js');
var util = require('../../utils/util.js');



var pageData = {
  data: {},
  need_login: false,
  page_router: 'home',
  page_form: 'none',
  list_compids_params: [{ "compid": "list_vessel4", "param": { "id": "list-559524224966", "form": "goods", "page": 1, "app_id": "GBx0maE3vC", "is_count": 0, "idx_arr": { "idx": "category", "idx_value": "48330" } } }, { "compid": "list_vessel6", "param": { "id": "list-722367552457", "form": "goods", "page": 1, "app_id": "GBx0maE3vC", "is_count": 0, "idx_arr": { "idx": "category", "idx_value": "47669" } } }],
  goods_compids_params: [],
  prevPage: 0,
  carouselGroupidsParams: [{ "compid": "carousel1", "carouselgroupId": "3967" }],
  relobj_auto: [],
  bbsCompIds: [],
  dynamicVesselComps: [],
  communityComps: [],
  franchiseeComps: [],
  cityLocationComps: [],
  onLoad: function (e) {
    wx.request({
      url: 'http://www.wechat.dev/api/v1/carouse',
      method: 'GET',
      header:{
        'content-type': 'application/json'
      },
      success: function (res) {
        // if (res.statusCode && res.statusCode != 200) {
        //   that.hideToast();
        //   that.showModal({
        //     content: '' + res.errMsg
        //   });
        //   return;
        // }
        // if (res.data.status) {
        //   if (res.data.status == 401 || res.data.status == 2) {
        //     // 未登录
        //     that.login();
        //     return;
        //   }
        //   if (res.data.status != 0) {
        //     that.hideToast();
        //     that.showModal({
        //       content: '' + res.data.data
        //     });
        //     return;
        //   }
        // }
        console.log('-----------------success-------------');
      },
      fail: function (res) {
        that.showModal({
          content: '请求失败 ' + res.errMsg
        })
        
      },
      complete: function (res) {
        // wx.hideLoading();
        that.hideToast();
        console.log('-----------------==========-------------');
        console.log(res);
      }
    });

    this.setData({
      addShoppingCartShow: false,
      addTostoreShoppingCartShow: false
    });
    appInstance.setPageUserInfo();
    if (e.detail) {
      this.dataId = e.detail;
    }
    appInstance.checkLogin();

    this.suspensionBottom();
    this.getCartList();
    appInstance.globalData.urlLocationId = e.location_id;

  },

  // 分享事件
  onShareAppMessage: function () {
    var pageRouter = this.page_router,
      pagePath = '/pages/' + pageRouter + '/' + pageRouter;

    // 统计用户分享APP
    appInstance.countUserShareApp();

    pagePath += this.dataId ? '?detail=' + this.dataId : '';
    return {
      title: appInstance.getAppTitle(),
      desc: appInstance.getAppDescription(),
      path: pagePath
    }
  },

  // 监听页面显示
  onShow: function () {
    var that = this;
    setTimeout(function () {
      appInstance.setPageUserInfo();
    });

    //用于判断当前页面是否需要验证手机号
    if (this.need_login && !appInstance.getUserInfo().phone) {
      appInstance.turnToPage('/pages/bindCellphone/bindCellphone');
    }
  },
  // 页面上拉触底事件的处理函数
  onReachBottom: function () {
    for (let i in this.data) {
      if (/^bbs[\d]+$/.test(i)) {
        appInstance.bbsScrollFuc(i);
      }
    }
  }
};
// 包含公共文件
let pageFunctionsObj = require('../../components/pageFunctions.js');
let pageFunctions = pageFunctionsObj.loadPageFunctionsExt(appInstance);
let pageDataAll = Object.assign(pageData, pageFunctions);
// console.log("-----------------------------");
// console.log(pageData.data.list_vessel6);
// console.log("-----------------------------");
Page(pageData);
