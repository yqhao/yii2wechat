// page/pages/orderList/orderList.js
var appInstance = getApp();
Page({
  prevPage: 0,
  /**
   * 页面的初始数据
   */
  data: {
    orderList:null,
    orderListPageInfo: null,
    paymentStatus:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    appInstance.checkLoginBackend();
    // console.log('--user info--');
    // console.log(appInstance.getUserInfo());
    
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let params = { 'per-page': '6'};
    if (options.payment_status != undefined && options.payment_status != null) {
      params['payment_status'] = parseInt(options.payment_status);
      currentPage.setData({
        'paymentStatus': parseInt(options.payment_status)
      });
    }
    let header = {
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    // console.log(params);
    appInstance.sendRequest({
      url: '/api/v1/orders',
      data: params,
      method: 'get',
      header: header,
      success: function (res) {
        // console.log(res);
        if (res != undefined && res.status == 1) {
          //  console.log(res.data);
          currentPage.setData({
            'orderList': res.data,
            'orderListPageInfo': res._meta
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

  pageScrollFunc: function (e) {

    var newdata = {};
    var currentPage = appInstance.getCurrentPagesFormat();
    let compid = e.target.dataset.compid;
    let curpage = parseInt(e.target.dataset.curpage)

    if (this.prevPage !== curpage && curpage < currentPage.data[compid + 'PageInfo'].pageCount) {
      this.prevPage = curpage;

      // console.log(e);
      let params = {'page': curpage + 1, 'per-page': '6' };
      if (e.target.dataset.paymentStatus != undefined && e.target.dataset.paymentStatus != null) {
        params['payment_status'] = parseInt(e.target.dataset.paymentStatus);
        currentPage.setData({
          'paymentStatus': parseInt(e.target.dataset.paymentStatus)
        });
      }
      let header = {
        'Authorization': 'Bearer ' + appInstance.getTokenKey(),
        'Auth-Key': appInstance.getAuthKey(),
      };
      // console.log(params);
      appInstance.sendRequest({
        url: '/api/v1/orders',
        data: params,
        method: 'get',
        header: header,
        success: function (res) {
          if (res != undefined && res.status == 1) {
            newdata = {};
            newdata[compid] = currentPage.data[compid].concat(res.data);
            newdata[compid + 'PageInfo'] = res._meta;
            currentPage.setData(newdata);
          }
        }
      })

    }
  },

})