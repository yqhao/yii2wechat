// page/pages/pay/pay.js
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    failMessage:null
  },
  //paymentInfo:null,
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    appInstance.checkLoginBackend();
    console.log('--user info--');
    console.log(appInstance.getUserInfo());
    // console.log('--payment info--');
    // console.log(options);
    //this.paymentInfo = options;

    if (options.type == 'no'){
      this.payNoMoney(options.id);
      return;
    }

    var currentPage = appInstance.getCurrentPagesFormat();
    currentPage.setData({ paymentInfo : options});
    // if (options != null){
    //   options.package = decodeURI(options.package);
    //   this.paymentInfo = options;
    // }
    //options.id = 27;
    //options.paymentParams;



  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  },





  // 调用微信支付接口
  wxPay: function () {
    var _this = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    var param = currentPage.data.paymentInfo;
    console.log(currentPage.data.paymentInfo);
    if (param == null){
      wx.showModal({
        title: '提示',
        content: '支付信息有误',
        showCancel: false,
        confirmText: '确定',
        confirmColor: '#3CC51F',
      })
      return;
    }

    var packageStr = param.package;
    if (param.package.indexOf('prepay_id%3D') != -1){
      packageStr = 'prepay_id=' + param.package.slice(12);
    }
    console.log(packageStr);
    wx.requestPayment({
      'nonceStr': param.nonceStr,
      'package': packageStr,
      'signType': 'MD5',
      'timeStamp': param.timeStamp,
      'paySign': param.paySign,
      success: function (res) {
        console.log('---success---');
        console.log(res);
        appInstance.turnToPage('/page/pages/orderSuccess/orderSuccess');
        //_this.wxPaySuccess(param);
        //typeof param.success === 'function' && param.success();
      },
      fail: function (res) {
        console.log(res);
        if (res.errMsg === 'requestPayment:fail cancel') {
          typeof param.fail === 'function' && param.fail();
          return;
        }
        if (res.errMsg === 'requestPayment:fail') {
          res.errMsg = '支付失败';
        }
        wx.showModal({
          title: '支付失败',
          content: res.errMsg,
          showCancel: false,
          confirmText: '确定',
          confirmColor: '#3CC51F',
        })
        return;
        //_this.wxPayFail(param, res.errMsg);
        typeof param.fail === 'function' && param.fail();
      }
    })
  },
  // 支付成功回调
  wxPaySuccess: function (param) {
    var orderId = param.orderId,
      goodsType = param.goodsType,
      formId = param.package.substr(10),
      t_num = goodsType == 1 ? 'AT0104' : 'AT0009';

    this.sendRequest({
      hideLoading: true,
      url: '/index.php?r=AppShop/SendXcxOrderCompleteMsg',
      data: {
        formId: formId,
        t_num: t_num,
        order_id: orderId
      }
    })
  },
  // 支付失败回调
  wxPayFail: function (param, errMsg) {
    var orderId = param.orderId,
      formId = param.package.substr(10);

    this.sendRequest({
      hideLoading: true,
      url: '/index.php?r=AppShop/SendXcxOrderCompleteMsg',
      data: {
        formId: formId,
        t_num: 'AT0010',
        order_id: orderId,
        fail_reason: errMsg
      }
    })
  },





  payNoMoney: function (orderId) {
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/pay',
      data: { 'id': orderId },
      method: 'post',
      header: header,
      success: function (res) {
        // appInstance.turnToPage('/page/pages/orderSuccess/orderSuccess');
        wx.navigateTo({
          url: '/page/pages/orderSuccess/orderSuccess',
        })
      },
      complete: function (res) {

        if (res.status != 1) {
          //currentPage.setData({ 'failMessage': res.message});
          setTimeout(function () {
            //wx.hideToast()
            // appInstance.turnToPage('/page/pages/orderList/orderList');
            // wx.navigateBack();
            var pages = getCurrentPages();;
            var prePage = pages[pages.length - 2];

            if (prePage.route == 'page/pages/orderConfirm/orderConfirm') {
              wx.redirectTo({
                url: '/page/pages/orderList/orderList'
              })
            }
            else {
              wx.navigateBack();
            }
          }, 2000);
        }

      }
    })
  },

})