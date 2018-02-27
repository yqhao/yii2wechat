// page/pages/payment/payment.js
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    orderId:null,
    order:null,
    payment:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

    // appInstance.showToast({
    //   title: '请求中...',
    //   icon: 'loading'
    // });
    
    appInstance.checkLoginBackend();
    // todo 设置order id用于查询订单信息
    if (options.orderId == undefined || !(options.orderId > 0)){
      // 支付失败页面
      // options.orderId = 99;
      options.orderId = 31;
      // options.orderId = 76;
    }
    var currentPage = appInstance.getCurrentPagesFormat();
    currentPage.setData({ orderId:options.orderId});

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
    var currentPage = appInstance.getCurrentPagesFormat();
    let orderId = currentPage.data.orderId;
    // todo 用order id查询订单信息
    console.log(orderId);
    this.getPaymentInfo(orderId);
    // setTimeout(function () { appInstance.hideToast(); }, 5000);
    
  },

  getPaymentInfo: function(orderId){
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/get-payment-info',
      data: {'orderId':orderId},
      method: 'GET',
      header: header,
      success: function (res) {
        console.log(res);
        if (res.status != 1){
          appInstance.toast({
            title: '未能查找到该订单',
            duration: 3000,
            cb: function () {
              wx.switchTab({
                url: '/page/pages/index/index'
              });
            }});
            return;
        }
        if (res.data.payment.status == 'PAID') {
          console.log('PAID');
          appInstance.turnToPage('/page/pages/orderDetail/orderDetail?id=' + res.data.order.id);
          return;
        }
        currentPage.setData({ 'order': res.data.order});
        currentPage.setData({ 'payment': res.data.payment });

        // 自动支付
        if (res.data.payment.type == 'DEFAULT' && res.data.order.payment_price <= 0){
          that.defaultPay(orderId);
        }

      },
      fail: function (res){
        wx.switchTab({
          url: '/page/pages/index/index'
        });
        return;
      }
    });
  },
  // 调用微信支付接口
  wxPay: function () {
    var currentPage = appInstance.getCurrentPagesFormat();
    var param = currentPage.data.payment.params;
    console.log(currentPage.data);
    console.log(param);

    var packageStr = param.package;
    if (param.package.indexOf('prepay_id%3D') != -1) {
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
        // 付款成功
        appInstance.turnToPage('/page/pages/paymentResult/paymentResult?status=success', true);
      },
      fail: function (res) {
        console.log(res);
        if (res.errMsg === 'requestPayment:fail cancel') {
          typeof param.fail === 'function' && param.fail();
          appInstance.turnToPage('/page/pages/orderList/orderList?payment_status=0', true);
          return;
        }
        if (res.errMsg === 'requestPayment:fail') {
          res.errMsg = '支付失败';
        }

        typeof param.fail === 'function' && param.fail();
        //付款失败
        appInstance.turnToPage('/page/pages/paymentResult/paymentResult?status=fail', true);
      }
    })
  },
  defaultPay: function (orderId) {
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/pay',
      // data: { 'id': orderId },
      method: 'post',
      header: header,
      success: function (res) {
        //付款成功
        console.log('付款成功');
        wx.redirectTo({
          url: '/page/pages/paymentResult/paymentResult?status=success&orderId=' + orderId
        }, true)
      },
      complete: function (res) {
        //付款失败
        if (res.status != 1){
          wx.redirectTo({
            url: '/page/pages/paymentResult/paymentResult?status=fail'
          }, true);
        }
      }
    })
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
  
  }
})