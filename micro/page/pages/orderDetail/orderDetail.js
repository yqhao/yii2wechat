// page/pages/orderDetail/orderDetail.js
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    orderInfo:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    appInstance.checkLoginBackend();
    // console.log('--user info--');
    // console.log(appInstance.getUserInfo());
    
    //console.log(options);
    // options.id = 27;
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let header = {
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/detail',
      data: { 'id': options.id },
      method: 'get',
      header: header,
      success: function (res) {
        if (res != undefined && res.status == 1) {
          currentPage.setData({
            'orderInfo': res.data,
          });

        }
      }
    })
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

  orderCancel:function(e){
    var that = this;
    appInstance.sendRequest({
      url: '/api/v1/order/cancel',
      data: { 'id': e.currentTarget.dataset.oid },
      method: 'post',
      complete: function (res) {
        if (res != undefined && res.status == 1) {
          appInstance.showToast({
            title: '取消成功',
            icon: 'success',
          });
          setTimeout(function () {
            wx.hideToast()
            appInstance.turnToPage('/page/pages/orderList/orderList');
          }, 1500);
        }
      }
    })
  },

  turnToPackage:function(e){
    appInstance.turnToPage('/page/pages/productDetail/productDetail?id=' + e.currentTarget.dataset.pid);
  }
})