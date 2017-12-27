// page/pages/pay/pay.js
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    failMessage:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    appInstance.checkLoginBackend();
    console.log('--user info--');
    console.log(appInstance.getUserInfo());
    
    //options.id = 27;
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/pay',
      data: { 'id': options.id },
      method: 'post',
      header: header,
      success: function (res) {
        // appInstance.turnToPage('/page/pages/orderSuccess/orderSuccess');
        wx.navigateTo({
          url: '/page/pages/orderSuccess/orderSuccess',
        })
      },
      complete:function(res){
        
        if(res.status != 1){
          //currentPage.setData({ 'failMessage': res.message});
          setTimeout(function () {
            //wx.hideToast()
            // appInstance.turnToPage('/page/pages/orderList/orderList');
            // wx.navigateBack();
            var pages = getCurrentPages();;
            var prePage = pages[pages.length - 2];

            if (prePage.route == 'page/pages/orderConfirm/orderConfirm'){
              wx.redirectTo({
                url: '/page/pages/orderList/orderList'
              })
            }
            else{
              wx.navigateBack();
            }
          }, 2000);
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
  
  }
})