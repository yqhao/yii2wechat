// page/pages/productDetail/productDetail.js
var WxParse = require('../../../vendor/wxParse/wxParse.js');
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    packageInfo:null,
    packageInfoDetail: null,
    purchaseNotice: null,
    trafficGuide: null,
    packageItems: null,
    showTicktNum:null
  },
  packageId: null,
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //console.log(options);
    var that = this;
    // 查询详情信息
    if (options.id == undefined || !options.id){
      wx.showModal({
        title: "错误",
        content: "页面不存在!",
        showCancel: false,
        confirmText: "返回",
        complete:function(){
          wx.navigateBack();
        }
      });
    }
    this.packageId = parseInt(options.id);
    var currentPage = appInstance.getCurrentPagesFormat();
    appInstance.sendRequest({
      url: '/api/v1/package/view',
      data: { 'id': this.packageId},
      method: 'get',
      success: function (res) {
        if (res != undefined && res.status == 1) {
          currentPage.setData({ 'packageInfo': res.data});
          // if(res.data.detail){
          //   WxParse.wxParse('packageInfoDetail', 'html', res.data.detail, that);
          // }
          if (res.data.purchase_notice) {
            WxParse.wxParse('purchaseNotice', 'html', res.data.purchase_notice, that);
          }
          if (res.data.traffic_guide) {
            WxParse.wxParse('trafficGuide', 'html', res.data.traffic_guide, that);
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
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    appInstance.sendRequest({
      url: '/api/v1/package-item',
      data: { 'package_id': this.packageId },
      method: 'get',
      success: function (res) {
        if (res != undefined && res.status == 1) {
          currentPage.setData({ 'packageItems': res.data });
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
  
  },
  tapTurnToDetail:function(e){
    appInstance.turnToPage('/page/pages/productDetailContent/productDetailContent?id=' + this.packageId);
  },
  tapImage:function(e){
    appInstance.turnToPage('/page/pages/album/album?id=' + this.packageId);
  },
  tapTicketDetail:function(e){
    // console.log();
    var that = this;
    var id = e.currentTarget.dataset.id;
    var currentPage = appInstance.getCurrentPagesFormat();
    var item = currentPage.data.packageItems[id];
    //console.log(item);
    if (id != undefined && item != undefined){
      var content = "<p style='padding-top: 6px'>" + item.title + "</p>";
      if (item.detail) {
        content += "<p style='padding: 12px 0 6px 0'><strong>【 详情 】</strong></p><p>" + item.detail + "</p>";
      }
      if (item.special_description){
        content += "<p style='padding: 12px 0 6px 0'><strong>【 特别说明 】</strong></p><p>" + item.special_description + "</p>";
      }
      if (item.unsubscribe_rules) {
        content += "<p style='padding: 12px 0 6px 0'><strong>【 退订规则 】</strong></p><p>" + item.unsubscribe_rules + "</p>";
      }

      if (item.change_rules) {
        content += "<p style='padding: 12px 0 6px 0'><strong>【 改期规则 】</strong></p><p>" + item.change_rules + "</p>";
      }
      if (item.important_clause) {
        content += "<p style='padding: 12px 0 6px 0'><strong>【 重要条款 】</strong></p><p>" + item.important_clause + "</p>";
      }

      WxParse.wxParse('layerContent', 'html', content , that);
      appInstance.modelShow({
        title: '商品说明',
        cover: item.cover,
        content: currentPage.data.layerContent.nodes
      });
    }


  },
  layerModelClose:function(e){
    appInstance.modelHide();
  }
})