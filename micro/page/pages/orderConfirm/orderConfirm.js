// page/pages/orderConfirm/orderConfirm.js
var appInstance = getApp();
var WxParse = require('../../../vendor/wxParse/wxParse.js');
var util = require('../../../util/util');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    packageItems: null,
    // tomorrow: { date: '-', price: 0 },
    // theDayAfterTomorrow:{date:'-',price:0},
    bookingDate: null,
    bookingFullDate: null,
    // price:0,
    // totalPrice: 0.0,
    // totalQuantity:1,

    bookingId: null,
    bookingPrice: 0.0,
    bookingTotalPrice: 0.0,
    bookingTotalQuantity: 0,

    tomorrow_active_class: 'active',
    theDayAfterTomorrow_active_class: 'unactive',
    btnQuantityAdd_class: 'active',
    btnQuantitySub_class: 'unactive',
    specialDescription: null,
    unsubscribeRules: null,
    changeRules: null,
    importantClause: null,
    showExplain:'hidde',

    couponCode:null,
    focusCoupon:false,
    discount:null,
    totalDiscount:0,
    payAmount:0,

    focusIdNumber: null,
    focusName:null,
    focusMobile:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    appInstance.checkLoginBackend();
    // console.log('--user info--');
    // console.log(appInstance.getUserInfo());
    
    // console.log(options);
    // options.id=8;
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();

    var params = {
      'id': options.id 
    };
    if (options.select_date != undefined && options.select_date){
      params.select_date = options.select_date;
    }

    appInstance.sendRequest({
      url: '/api/v1/package-item/view',
      data: params,
      method: 'get',
      success: function (res) {
        if (res != undefined && res.status == 1) {
          currentPage.setData({
            'packageItems': res.data,

            'bookingId': res.data.id,
            'bookingDate': res.data.tomorrow.date,
            'bookingFullDate': res.data.tomorrow.full_date,
            'bookingPrice': res.data.tomorrow.price,
            'bookingTotalPrice': res.data.tomorrow.price,
            'payAmount': res.data.tomorrow.price,
            'bookingTotalQuantity': 1,


            // 'price': res.data.tomorrow.price,
            // 'totalPrice': parseFloat(res.data.tomorrow.price),
            // 'totalQuantity': 1,
            'tomorrow_active_class': 'active',
          });
          if (res.data.special_description) {
            WxParse.wxParse('specialDescription', 'html', res.data.special_description, that);
          }
          if (res.data.unsubscribe_rules) {
            WxParse.wxParse('unsubscribeRules', 'html', res.data.unsubscribe_rules, that);
          }
          if (res.data.change_rules) {
            WxParse.wxParse('changeRules', 'html', res.data.change_rules, that);
          }
          if (res.data.important_clause) {
            WxParse.wxParse('importantClause', 'html', res.data.important_clause, that);
          }
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
  tapToSelectDate: function (e) {
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();
    // console.log(e);
    // console.log(currentPage);
    currentPage.setData({
      'bookingDate': e.currentTarget.dataset.bookingDate,
      'bookingFullDate': e.currentTarget.dataset.bookingFullDate,
      'bookingPrice': e.currentTarget.dataset.bookingPrice,
      'bookingTotalPrice': parseFloat(currentPage.data.bookingTotalQuantity * e.currentTarget.dataset.bookingPrice),
      'payAmount': parseFloat(currentPage.data.bookingTotalQuantity * e.currentTarget.dataset.bookingPrice),
    });
    this.checkCoupon(currentPage);
    if (e.currentTarget.dataset.id == 'tomorrow') {
      currentPage.setData({
        'tomorrow_active_class': 'active',
        'theDayAfterTomorrow_active_class': 'unactive',
      });
    } else if (e.currentTarget.dataset.id == 'theDayAfterTomorrow') {
      currentPage.setData({
        'tomorrow_active_class': 'unactive',
        'theDayAfterTomorrow_active_class': 'active',
      });
    }
    //console.log(currentPage);
  },

  tapQuantityAdd: function () {
    var currentPage = appInstance.getCurrentPagesFormat();
    let quantity = currentPage.data.bookingTotalQuantity + 1;
    // console.log(currentPage);
    // console.log(quantity);
    currentPage.setData({
      'bookingTotalQuantity': quantity,
      'bookingTotalPrice': parseFloat(quantity * currentPage.data.bookingPrice),
      'payAmount': parseFloat(quantity * currentPage.data.bookingPrice),
      'btnQuantitySub_class': 'active',
    });
    this.checkCoupon(currentPage);
  },
  tapQuantitySub: function () {
    var currentPage = appInstance.getCurrentPagesFormat();
    let quantity = currentPage.data.bookingTotalQuantity - 1;
    if (quantity > 0) {
      currentPage.setData({
        'bookingTotalQuantity': quantity,
        'bookingTotalPrice': parseFloat(quantity * currentPage.data.bookingPrice),
        'payAmount': parseFloat(quantity * currentPage.data.bookingPrice),
        'btnQuantitySub_class': quantity > 1 ? 'active' : 'unactive',
      });
      this.checkCoupon(currentPage);
    }
  },
  formSubmit: function (e) {
    var currentPage = appInstance.getCurrentPagesFormat();
    // if (e.detail.value.coupon == undefined || !e.detail.value.coupon) {
    //   currentPage.setData({ focusCoupon: true });
    //   appInstance.toast({ title: '请填写优惠码' });
    //   return false;
    // }
    if (e.detail.value.contactName == undefined || !e.detail.value.contactName) {
      currentPage.setData({ focusName: true });
      appInstance.toast({ title: '请填写联系人' });
      return false;
    }
    if (e.detail.value.contactMobile == undefined || !e.detail.value.contactMobile) {
      currentPage.setData({ focusMobile: true });
      appInstance.toast({ title: '请填写手机号' });
      return false;
    }
    if (e.detail.value.contactIdNumber == undefined || !e.detail.value.contactIdNumber) {
      currentPage.setData({ focusIdNumber: true });
      appInstance.toast({ title: '请填写身份证号' });
      return false;
    }

    var that = this;
    

    let params = {
      'version':'2',
      'package_id': currentPage.data.packageItems.package_id,
      'package_item_id': currentPage.data.packageItems.id,
      'total_quantity': currentPage.data.bookingTotalQuantity,
      'use_date': currentPage.data.bookingFullDate,
      'coupon_code': currentPage.data.couponCode,
      'contact_id_number': e.detail.value.contactIdNumber,
      'contact_name': e.detail.value.contactName,
      'contact_mobile': e.detail.value.contactMobile,
      'remark': e.detail.value.remark
    };
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    //console.log(params);
    appInstance.sendRequest({
      url: '/api/v1/order/add',
      data: params,
      method: 'POST',
      header: header,
      success: function (res) {
        // console.log(res);
        if (res != undefined && res.status == 1) {
          if (params.version == 2){
            appInstance.turnToPage('/page/pages/payment/payment?orderId=' + res.data.order_id,true);
          }else{
            var url_pay = '/page/pages/pay/pay?id=' + res.data.order_id + '&amount=' + res.data.total_pay_amount;
            if (res.paymentParams == undefined || res.paymentParams == '' || res.paymentParams == null) {
              url_pay += '&type=no';
            } else {
              url_pay += '&type=wx&' + util.json2Form(res.paymentParams);
            }
            appInstance.turnToPage(url_pay);
          }
        }
      },
      complete: function (res) {
        //console.log(res);
        if (res.status != 1 && res.error != undefined) {
          let message = '';
          for (var i = 0; i < res.error.length; i++) {
            message += res.error[i]['message'];
          }
          appInstance.showModal({
            title: '下单失败!',
            content: message
          });
        }
      },
    })

  },

  


  tapExplain:function(e){
    var currentPage = appInstance.getCurrentPagesFormat();
    if (e.currentTarget.dataset.showStatus == 'hidde'){
      currentPage.setData({'showExplain':''});
    }else{
      currentPage.setData({ 'showExplain': 'hidde' });
    }
    
  },

  tapCheckCoupon: function (e){
    var that = this;
    var currentPage = appInstance.getCurrentPagesFormat();

    if (e.detail.value == undefined || !e.detail.value) {
      return false;
    }
    currentPage.setData({'couponCode': e.detail.value});
    this.checkCoupon(currentPage);
  },
  checkCoupon: function (currentPage){
    // var that = this;
    // var currentPage = appInstance.getCurrentPagesFormat();

    if (currentPage.data.couponCode == undefined || !currentPage.data.couponCode){
      return false;
    }
    // console.log('check');
    // console.log(currentPage);
    currentPage.setData({
      'discount': null,
      'totalDiscount': 0
    });
    let params = {
      'code': currentPage.data.couponCode,
      'total_price': currentPage.data.bookingTotalPrice,
      'total_quantity': currentPage.data.bookingTotalQuantity
    };
    // console.log(params);
    let header = {
      'content-type': 'application/x-www-form-urlencoded;',
      'Authorization': 'Bearer ' + appInstance.getTokenKey(),
      'Auth-Key': appInstance.getAuthKey(),
    };
    appInstance.sendRequest({
      url: '/api/v1/order/check-coupon',
      data: params,
      method: 'POST',
      header: header,
      success: function (res) {
        let amount = 0;
        if (res.data.type == 1){
          amount = res.data.amount;
          let payAmount = currentPage.data.bookingTotalPrice - amount;
          currentPage.setData({
            'discount': res.data,
            'totalDiscount': amount,
            'payAmount': payAmount > 0 ? payAmount : 0,
          });
        }
        
      },
    })

  },

  tapMoreDate:function(e){
    var currentPage = appInstance.getCurrentPagesFormat();
    appInstance.turnToPage('/page/pages/calendar/calendar?id=' + currentPage.data.bookingId
      + '&selectDate=' + currentPage.data.bookingFullDate
    );
  },

})