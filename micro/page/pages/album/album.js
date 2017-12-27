// page/pages/album/album.js
var WxParse = require('../../../vendor/wxParse/wxParse.js');
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    images:null,
    imageList:null,
    pageInfo:{
      totalCounts:0,
      page:0,
      size:4
    }
  },
  packageId:null,
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.getImages(options.id);
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
    // var that = this;
    // var currentPage = appInstance.getCurrentPagesFormat();
    // WxParse.wxParse('imagesPage', 'html', currentPage.data.images, that);
    this.setNextList();
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
  getImages:function(id){
    var that = this;
    // 查询详情信息
    if (id == undefined || !id) {
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
    this.packageId = parseInt(id);
    var currentPage = appInstance.getCurrentPagesFormat();
    appInstance.sendRequest({
      url: '/api/v1/package/images',
      data: { 'id': this.packageId },
      method: 'get',
      success: function (res) {
        if (res != undefined && res.status == 1) {
          if (res.data) {
            currentPage.setData({ 'images': res.data });
            that.setNextList();
          }
        }
      }
    });
  },
  tapImage: function (ev){
    let currentPage = appInstance.getCurrentPagesFormat();
    wx.previewImage({
      current: ev.currentTarget.dataset.url, // 当前显示图片的http链接
      urls: currentPage.data.images // 需要预览的图片http链接列表
    })
  },
  setNextList:function(page){
    let caurrentPageNumber = page == null ? 0 : page;
    let list = {};
    let i = 0;
    let currentPage = appInstance.getCurrentPagesFormat();

    let images = currentPage.data.images;
    if (images == null){
      return;
    }

    let nextPage = parseInt(caurrentPageNumber) + 1;
    let totalCounts = parseInt(images.length);
    let size = parseInt(currentPage.data.pageInfo.size);
    let totalPages = Math.ceil(totalCounts / size);

    let endKey = nextPage*size;
    endKey = endKey < totalCounts ? endKey :totalCounts;

    if (nextPage > totalPages) {
      return;
    }
    for (i; i < endKey; i++) {
      list[i] = images[i];
    }
    console.log(nextPage);
    console.log(list);
    currentPage.setData({
      imageList: list,
      pageInfo: { totalCount: totalCounts, page: nextPage, size: size }
    });
  },
  pageScrollFunc: function (e) {
    this.setNextList(e.target.dataset.page);
  },
})