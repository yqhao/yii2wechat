
var app = getApp()
var util = require('../../utils/util.js')

Page({
  data: {
    communityId: '',
    articleData : {
      title : '',
      text : '',
      imgs : [],
      category_id : ''
    },
    category : [],
    picker_value : '全部',
    theme_color : '#00b6f8'
  },
  onLoad: function(options){
    let communityId = options.detail;

    this.setData({
      communityId: communityId
    });

    this.getThemeColor( communityId );
    this.getCategory();
  },
  submitData : function(event) {
    let that = this;

    if( !that.data.articleData.title ){
      app.showModal({content : '请填写标题'});
      return ;
    }
    if( !that.data.articleData.text ){
      app.showModal({content : '请填写话题内容'});
      return ;
    }
    app.sendRequest({
      url: '/index.php?r=AppSNS/AddArticle',
      data: {
        section_id : that.data.communityId , //版块id
        category_id : that.data.articleData.category_id, //分类id 可不传
        title : that.data.articleData.title ,
        text : that.data.articleData.text ,
        imgs : that.data.articleData.imgs ,
        is_carousel : 0, //是否开启轮播 1为开启 0不开启
        top_flag :  0, //是否置顶 1为置顶 0不置顶
        hot_flag :  0 //是否精品 1是 0否
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          app.showToast({
            title : '发布成功' , 
            success : function(){
              app.turnBack();
            }
          });
          app.globalData.communityPageRefresh = true;
        }
      }
    });
  },
  bindTitleInput : function(event) {
    let val = event.detail.value;
    this.setData({
      'articleData.title' : val
    });
  },
  bindTextInput : function(event) {
    let val = event.detail.value;
    this.setData({
      'articleData.text' : val
    });
  },
  bindPickerChange : function(event){
    let val = event.detail.value;
    this.setData({
      'articleData.category_id' : this.data.category[val].id,
      picker_value : this.data.category[val].name
    });
  },
  uploadImg : function(){
    var that = this,
        imgs = that.data.articleData.imgs;

    app.chooseImage(function(imageUrls){
      imgs = imgs.concat(imageUrls);
      that.setData({
        'articleData.imgs' : imgs
      });
    } , 9);
  },
  deleteImg : function(event){
    var index = event.currentTarget.dataset.index,
        imgs = this.data.articleData.imgs;

    imgs.splice(index , 1);
    this.setData({
      'articleData.imgs' : imgs
    });
  },
  getCategory : function() {
    var that = this;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetCategoryByPage',
      data: {
        section_id : that.data.communityId ,
        page: 1 ,
        page_size: 100
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data,
              newdata = [{id: '' , name: '全部'}].concat(info);
          that.setData({
            category: newdata
          });
        }
      }
    });
  },
  getThemeColor : function( section_id ) {
    var that = this;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetSectionByPage',
      data: {
        page:  1 ,
        section_id : section_id
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data[0];

          that.setData({
            theme_color: info.theme_color
          });
        }
      }
    });
  }
})
