// page/pages/index.js
var encoding = require('../../../vendor/encoding/sha1.js');
var wxApi = require('../../../util/wxApi')
var wxRequest = require('../../../util/wxRequest')
var util = require('../../../util/util');

var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    config: [],
    indexAds: null,
    packageListPageInfo: null,
    packageList: null,

  },
  prevPage: 0,
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('Index Launch');
    var that = this;
    // 顶部广告
    appInstance.sendRequest({
      'url': '/api/v1/widget-carousel?expand=items', 'data': [],
      'complete': function (res) {
        if (res.status == 1) {
          that.setData({ indexAds: res.data[0].items });
          //  console.log(that.indexAds)
        }
      }
    });

    // // 列表
    // appInstance.sendRequest({
    //   'url': '/api/v1/package/index?category_id=1&page=1&per-page=5', 'data': [],
    //   'complete': function (res) {
    //     if (res.status == 1) {
    //       that.setData({ packageList: res.data, packageListPageInfo: res._meta });
    //       //  console.log(that.indexAds)
    //     }
    //   }
    // });
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    console.log('Index onReady');
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    console.log('Index onShow');
    // appInstance.requestUserInfoWx();
    // 列表
    var that = this;
    appInstance.sendRequest({
      'url': '/api/v1/package/index?category_id=1&page=1&per-page=5', 'data': [],
      'complete': function (res) {
        if (res.status == 1) {
          that.setData({ packageList: res.data, packageListPageInfo: res._meta });
          //  console.log(that.indexAds)
        }
      }
    });
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
  // onReachBottom: function (e) {
  //   console.log('onReachBottom');
  //   console.log(e);
  // },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },

  tapToPackageDetail: function (e) {
    let pid = parseInt(e.currentTarget.dataset.packageId);
    if (pid) {
      appInstance.turnToPage('/page/pages/productDetail/productDetail?id=' + pid);
    }

  },
  turnToProductDetailPage: function (e) {
    if (e.target.dataset.url) {
      appInstance.turnToPage(e.target.dataset.url);
    }
  },


  pageScrollFunc: function (e) {

    var newdata = {};
    var currentPage = appInstance.getCurrentPagesFormat();
    let compid = e.target.dataset.compid;
    let curpage = parseInt(e.target.dataset.curpage)

    // console.log(this.prevPage);
    // console.log(curpage);
    // console.log(currentPage.data[compid + 'PageInfo'].pageCount);
    // console.log('---------');

    if (this.prevPage !== curpage && curpage < currentPage.data[compid + 'PageInfo'].pageCount) {
      this.prevPage = curpage;

      console.log(curpage);
      let param = { 'category_id': 1, 'page': curpage + 1, 'per-page': '5' };

      appInstance.sendRequest({
        url: '/api/v1/package/index',
        data: param,
        method: 'get',
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