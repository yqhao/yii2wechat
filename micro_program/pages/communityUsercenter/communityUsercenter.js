
var app = getApp()
var util = require('../../utils/util.js')

Page({
  data: {
    communityId: '',
    tabActive : 'publish' ,
    myArticleCount : 0 ,
    myArticleList : [],
    getMyArticleData : {
      page : 1 ,
      loading : false ,
      nomore : false
    },
    imgData : {} ,
    myCommentData : {
      page : 1 ,
      loading : false ,
      nomore : false
    },
    myCommentList : [],
    myCommentCount : 0,
    theme_color : '#00b6f8'
  },
  onLoad: function(options){
    let communityId = options.detail;

    this.setData({
      communityId: communityId
    });

    this.getThemeColor( communityId );
    this.getMyArticle();
    this.getMyComment();
  },
  getMyArticle : function() {
    var that = this,
        sdata = that.data.getMyArticleData ;

    if(sdata.loading || sdata.nomore){
      return ;
    }
    sdata.loading = true;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetArticleByPage',
      data: {
          page: sdata.page ,
          section_id : that.data.communityId ,
          only_own_record : 1 ,
          page_size: 10
      } ,
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data,
              oldData = that.data.myArticleList,
              newData = [];

          for (let i = 0; i < res.data.length; i++) {
            let idata = res.data[i];
            idata.title = unescape(idata.title.replace(/\\u/g, "%u"));
            idata.content_text = idata.content.text.replace(/\n|\\n/g , '\n');

            newData.push(idata);
          }

          newData = oldData.concat(newData);
          if(sdata.page == 1){
            that.setData({
              myArticleCount : res.count
            });
          }
          that.setData({
            myArticleList: newData ,
            'getMyArticleData.page' : sdata.page + 1
          });

        }
        that.setData({
          'getMyArticleData.loading': false ,
          'getMyArticleData.nomore' : res.is_more == 0 ? true : false
        });
      },
      fail: function(res){
        that.setData({
          'getMyArticleData.loading': false
        });
      }
    });
  },
  getMyComment : function() {
    var that = this,
        sdata = that.data.myCommentData ;

    if(sdata.loading || sdata.nomore){
      return ;
    }
    sdata.loading = true;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetCommentByPage',
      data: {
          page: sdata.page ,
          section_id : that.data.communityId ,
          only_own_record : 1 ,
          page_size: 10
      } ,
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data,
              oldData = that.data.myCommentList,
              newData = [];

          for (let i = 0; i < res.data.length; i++) {
            let idata = res.data[i];
            idata.content_text = idata.content.text.replace(/\n|\\n/g , '\n');

            newData.push(idata);
          }

          newData = oldData.concat(newData);
          if(sdata.page == 1){
            that.setData({
              myCommentCount : res.count
            });
          }
          that.setData({
            myCommentList: newData ,
            'myCommentData.page' : sdata.page + 1
          });

        }
        that.setData({
          'myCommentData.loading': false ,
          'myCommentData.nomore' : res.is_more == 0 ? true : false
        });
      },
      fail: function(res){
        that.setData({
          'myCommentData.loading': false
        });
      }
    });
  },
  imgLoad : function(event,) {
    let owidth = event.detail.width,
        oheight = event.detail.height,
        oscale = owidth / oheight,
        cwidth = 290 ,
        cheight = 120,
        ewidth , eheight,
        index = event.currentTarget.dataset.index,
        newData = {};

    if( oscale > cwidth / cheight ){
      ewidth = cwidth;
      eheight = cwidth / oscale;
    }else{
      ewidth = cheight * oscale;
      eheight = cheight;
    }

    newData['imgData.' + index] = {
      imgWidth : ewidth * 2.34,
      imgHeight : eheight * 2.34
    }
    this.setData(newData);
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
  },
  changeTab : function(event) {
    let type = event.currentTarget.dataset.type;
    this.setData({
      tabActive : type
    });
  },
  myArticleScroll : function(event) {
    this.getMyArticle();
  },
  myCommentScroll : function(event) {
    this.getMyComment();
  },
  turnBack : function(){
    app.turnBack();
  },
  turnToDetail : function(event) {
    let id = event.currentTarget.dataset.id;
    app.turnToPage('/pages/communityDetail/communityDetail?detail=' + id);
  }
})
