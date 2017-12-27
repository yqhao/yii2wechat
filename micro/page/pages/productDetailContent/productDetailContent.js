// page/pages/productDetailContent/productDetailContent.js
var appInstance = getApp();
var WxParse = require('../../../vendor/wxParse/wxParse.js');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    packageInfoDetail: null,
  },
  packageId:null,
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this;
    // 查询详情信息
    if (options.id == undefined || !options.id) {
      wx.showModal({
        title: "错误",
        content: "页面不存在!",
        showCancel: false,
        confirmText: "返回",
        complete: function () {
          wx.navigateBack();
        }
      });
    }
    this.packageId = parseInt(options.id);
    var currentPage = appInstance.getCurrentPagesFormat();
    appInstance.sendRequest({
      url: '/api/v1/package/detail',
      data: { 'id': this.packageId },
      method: 'get',
      success: function (res) {
        if (res != undefined && res.status == 1) {
          // currentPage.setData({ 'packageInfo': res.data });
          if (res.data) {
            WxParse.wxParse('packageInfoDetail', 'html', res.data, that);
          }
        }
      }
    });
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