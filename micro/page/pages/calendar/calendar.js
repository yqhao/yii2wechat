// page/pages/calendar/calendar.js
var appInstance = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    packageId:null,
    selectDate:null,
    page:1,

    lastPage:null,
    nextPage:null,
    title:null,
    calendar:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // options.id = 8;
    // options.selectDate = '2017-12-23';
    var currentPage = appInstance.getCurrentPagesFormat();
    currentPage.setData({
      'packageId': options.id,
      'selectDate': options.selectDate,
      'page': options.page
    });
    this.getCalendar(options.id, options.selectDate, options.page);
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
  getCalendar:function(packageId,selectDate,page=1){
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    let params = { 'id': packageId, 'selectDate': selectDate,'page': page };

    let header = {
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    // console.log(params);
    appInstance.sendRequest({
      url: '/api/v1/order/get-date',
      data: params,
      method: 'get',
      header: header,
      success: function (res) {
        // console.log(res);
        if (res != undefined && res.status == 1) {
          //  console.log(res.data);
          currentPage.setData({
            'lastPage': res.data.lastPage,
            'nextPage': res.data.nextPage,
            'title': res.data.title,
            'calendar': res.data.calendar
          });
        }
      }
    })
  },

  tapFlashPage:function(e){
    // console.log(e);
    // e.currentTarget.dataset.page;
    var currentPage = appInstance.getCurrentPagesFormat();
    this.getCalendar(currentPage.data.packageId, currentPage.data.selectDate, e.currentTarget.dataset.page);
  },

  tapSelectDate:function(e){
    var currentPage = appInstance.getCurrentPagesFormat();
    
    var date = e.currentTarget.dataset.year + '-' + e.currentTarget.dataset.month + '-' + e.currentTarget.dataset.day;
    currentPage.setData({
      'selectDate': date
    });
    console.log(date);
    appInstance.turnToPage('/page/pages/orderConfirm/orderConfirm?id=' + currentPage.data.packageId
      + '&select_date=' + date,true
    );
  },
})