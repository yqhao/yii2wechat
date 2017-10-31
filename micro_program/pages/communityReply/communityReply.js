
var app = getApp()
var util = require('../../utils/util.js')

Page({
  data: {
    sectionId: '' ,
    articleId : '',
    commentId: '',
    commentText : '',
    theme_color : '#00b6f8'
  },
  onLoad: function(options){
    let articleId = options.articleId,
        sectionId = options.sectionId,
        commentId = options.commentId;

    this.setData({
      sectionId : sectionId,
      articleId : articleId,
      commentId : commentId
    });
    this.getThemeColor( sectionId );
  },
  bindReplyInput : function(event) {
    let val = event.detail.value;
    this.setData({
      'commentText' : val
    });
  },
  submitData : function(event) {
    let that = this;

    if( !that.data.commentText ){
      app.showModal({content : '请填写回复内容'});
      return ;
    }

    app.sendRequest({
      url: '/index.php?r=AppSNS/AddComment',
      data: {
        section_id : that.data.sectionId ,
        article_id : that.data.articleId , // 话题id
        comment_id : that.data.commentId , // 评论id 如果传这个表示是在回复
        text : that.data.commentText ,
        imgs : ''
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          app.showToast({
            title : '回复成功' , 
            success : function(){
              app.turnBack();
            }
          });
          app.globalData.communityPageRefresh = true;
          app.globalData.communityDetailRefresh = true;
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
