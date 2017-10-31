
var app = getApp()
var util = require('../../utils/util.js')

Page({
  data: {
    communityId: '',
    communityInfo: {},
    category : [{id: 0 , name : '全部'}],
    categoryActive : 0 ,
    carouselImg : [],
    sectionList : [],
    getSectionData : {
      page : 1 ,
      loading : false ,
      nomore : false
    },
    search_value : '',
    imgData : {},
    showAddArticleBtn : true
  },
  onLoad: function(options){
    let communityId = options.detail;

    this.setData({
      communityId: communityId
    });

    this.getSectionInfo( communityId );
    this.getCategory( communityId );

    app.globalData.communityPageRefresh = false;
  },
  onShow : function(){
    if(app.globalData.communityPageRefresh){
      this.setData({
        getSectionData : {
          page : 1 ,
          loading : false ,
          nomore : false
        },
        sectionList : []
      });
      app.globalData.communityPageRefresh = false;
      this.getSectionList();
    }
  },
  page: 'communityPage',
  getSectionInfo : function(sId) {
    var that = this;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetSectionByPage',
      data: {
        section_id : sId ,
        page: 1 ,
        page_size: 100
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data[0];
          that.setData({
            communityInfo: info
          });

          if(info.has_carousel == 1){
            that.getCarousel( sId );
          }
        }
      }
    });
  },
  getCategory : function(sId) {
    var that = this;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetCategoryByPage',
      data: {
        section_id : sId ,
        page: 1 ,
        page_size: 100
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data,
              cData = that.data.category;
          cData = cData.concat(info);
          that.setData({
            category: cData
          });

          that.getSectionList();
        }
      }
    });
  },
  getSectionList : function() {
    var that = this,
        sdata = that.data.getSectionData ;

    if(sdata.loading || sdata.nomore){
      return ;
    }
    sdata.loading = true;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetArticleByPage',
      data: {
          page: sdata.page ,
          section_id : that.data.communityId ,
          category_id : that.data.categoryActive ,
          // orderby : 'id' ,
          article_id : '',  // （如果传了这个话题id就能获取单条话题信息）
          top_flag : 0 ,  //如果为1 筛选置顶帖
          hot_flag: 0 ,  //如果为1 筛选精品贴
          start_date : '',  // 查询开始日期
          end_date : '',   //查询结束日期
          search_value : that.data.search_value ,  // 查询值
          page_size: 10
      } ,
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          let info = res.data,
              oldData = that.data.sectionList,
              newData = [];

          for (let i = 0; i < res.data.length; i++) {
            let idata = res.data[i],
                ctext = that.showEllipsis( idata.content.text );

            idata.title = unescape(idata.title.replace(/\\u/g, "%u"));
            idata.content_text = ctext.text;
            idata.isellipsis = ctext.isellipsis;
            idata.likeAnimateShow = true;
            newData.push(idata);
          }

          newData = oldData.concat(newData);
          that.setData({
            sectionList: newData ,
            'getSectionData.page' : sdata.page + 1
          });
        }
        that.setData({
          'getSectionData.loading': false ,
          'getSectionData.nomore' : res.is_more == 0 ? true : false
        });
      },
      fail: function(res){
        that.setData({
          'getSectionData.loading': false
        });
      }
    });
  },
  getCarousel: function(sId) {
    var that = this;
    app.sendRequest({
      url: '/index.php?r=AppSNS/GetArticleByPage',
      data: {
        page: 1 ,
        section_id : sId ,
        is_carousel : 1 ,
        orderby : 'id' ,
        page_size: 10
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {
          var info = res.data;
          that.setData({
            carouselImg: info
          });
        }
      }
    });
  },
  tapCategory : function(event) {
    let id = event.currentTarget.dataset.id;
    this.setData({
      categoryActive : id ,
      sectionList: [] ,
      getSectionData : {
        page : 1 ,
        loading : false ,
        nomore : false
      }
    });

    this.getSectionList();
  },
  scrollTolower : function(event) {
    this.getSectionList();
  },
  oldscrolltop : 0 ,
  scrollEvent : function(event){
    let scrolltop = event.detail.scrollTop,
        oldscrolltop = this.oldscrolltop;

    if(scrolltop - oldscrolltop > 60){
      this.oldscrolltop = scrolltop;
      this.setData({
        showAddArticleBtn : false
      });
    }else if(oldscrolltop - scrolltop > 60){
      this.oldscrolltop = scrolltop;
      this.setData({
        showAddArticleBtn : true
      });
    }
  },
  bindKeyInput : function(event) {
    let val = event.detail.value;
    this.setData({
      'search_value' : val
    });
  },
  bindconfirmInput : function( event ) {
    this.setData({
      sectionList: [] ,
      getSectionData : {
        page : 1 ,
        loading : false ,
        nomore : false
      }
    });
    this.getSectionList();
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
  showEllipsis : function(oldtext) {
    let that = this,
        newtext = '',
        newtextarr = [],
        textarr = oldtext.split(/\n|\\n/) ,
        eachline = (app.systemInfo.windowWidth - 35) / 12 * 2,
        total_line_num = 5,
        has_line_num = 0,
        isellipsis = false;

    for (let i = 0; i < textarr.length; i++) {
        let len = that.stringLength( textarr[i] ),
            lenline = Math.ceil(len /  eachline);


        if( has_line_num + lenline >= total_line_num ){
            let spare_line = total_line_num - has_line_num;
            newtextarr.push( that.subString( textarr[i] , (spare_line*eachline - 16) ) + '...' );
            isellipsis = true;
            break ;
        }else{
            has_line_num += lenline;
            newtextarr.push( textarr[i] );
        }
    }
    if(isellipsis){
        newtext = newtextarr;
    }else{
        newtext = textarr;
    }

    return {text: newtext , isellipsis : isellipsis};
  },
  //获得字符串实际长度，中文2，英文1
  stringLength :function(str) {
    let realLength = 0, len = str.length, charCode = -1;
    for (let i = 0; i < len; i++) {
      charCode = str.charCodeAt(i);
      if(charCode > 128){
          realLength += 2;
      }else{
          realLength +=1;
      }
    }
    return realLength;
  },
  // 截取字符串 中文2，英文1
  subString : function(str, len) {
      let newLength = 0 ,
          newStr = "" ,
          chineseRegex = /[^\x00-\xff]/g ,
          singleChar = "",
          strLength = str.replace(chineseRegex,"**").length;
      for(let i = 0;i < strLength;i++) {
          singleChar = str.charAt(i).toString();
          if(singleChar.match(chineseRegex) != null) {
              newLength += 2;
          }else {
              newLength++;
          }
          if(newLength > len) {
              break;
          }
          newStr += singleChar;
      }
      if(strLength > len) {
          newStr += "...";
      }
      return newStr;
  },
  turnToDetail : function(event) {
    let id = event.currentTarget.dataset.id;
    app.turnToPage('/pages/communityDetail/communityDetail?detail=' + id);
  },
  turnToUsercenter : function(event) {
    app.turnToPage('/pages/communityUsercenter/communityUsercenter?detail=' + this.data.communityId );
  },
  turnToNotify : function(event){
    app.turnToPage('/pages/communityNotify/communityNotify?detail=' + this.data.communityId );
  },
  turnToPublish : function(event) {
    app.turnToPage('/pages/communityPublish/communityPublish?detail=' + this.data.communityId );
  },
  turnComment : function(event) {
    let sectionId = this.data.communityId ,
        articleId = event.currentTarget.dataset.id ;

    app.turnToPage('/pages/communityReply/communityReply?sectionId=' + sectionId + '&articleId=' + articleId);
  },
  articleLike : function(event) {
    let that = this,
        liked = event.currentTarget.dataset.liked,
        id = event.currentTarget.dataset.id,
        index = event.currentTarget.dataset.index;

    app.sendRequest({
      url: '/index.php?r=AppSNS/PerformLike',
      data: {
        obj_type : 1 ,  // obj_type 1-话题 2-评论
        obj_id : id     // obj_id 话题或评论的id
      },
      method: 'post',
      success: function (res) {
        if (res.status == 0) {

          if(liked == 1){
            let newData = {};
            newData['sectionList['+index+'].is_liked'] = 0;
            newData['sectionList['+index+'].like_count'] = +that.data.sectionList[index].like_count - 1;
            newData['sectionList['+index+'].likeAnimateShow'] = false;

            that.setData(newData);
            app.showToast({title : '点赞取消成功'});
          }else{
            let newData = {};
            newData['sectionList['+index+'].is_liked'] = 1;
            newData['sectionList['+index+'].like_count'] = +that.data.sectionList[index].like_count + 1;
            newData['sectionList['+index+'].likeAnimateShow'] = false;
            
            that.setData(newData);
            app.showToast({title : '点赞成功'});
          }
          setTimeout(function(){
            let newData = {};
            newData['sectionList['+index+'].likeAnimateShow'] = true;
            that.setData(newData);
          } , 480);
        }
      }
    });
  }
})
