import {
  Home
} from 'home-model.js';
var home = new Home(); //实例化 首页 对象

Page({
  data: {
    loadingHidden: false,
    searchPanelShow: false,
    containerShow: true,
    inputValue: null,
    searchResult: {}
  },
  onShow: function() {
    this._loadData();
    this.setData({
      containerShow: true,
      searchPanelShow: false,
      searchResult: {},
      inputValue: null
    })
  },

  /*加载所有数据*/
  _loadData: function(callback) {
    var that = this;

    // 获得bannar信息
    home.getBannerData((data) => {
      that.setData({
        bannerArr: data,
        loadingHidden: true
      });
    });

    // 获取user_id信息
    //  wx.setStorageSync('user_id', res.data.user_id);
    home.getUser((data) => {
      wx.setStorageSync('user_id', data.user_id);

    });


    /*获取主题信息*/
    // home.getThemeData((data) => {
    //     that.setData({
    //         themeArr: data,
    //         loadingHidden: true
    //     });
    // });

    /*获取最近发布信息*/
    home.getProductorData((data) => {
      that.setData({
        productsArr: data
      });
      callback && callback();
    });
  },

  /*跳转到商品详情*/
  onProductsItemTap: function(event) {
    var id = home.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id
    })
  },

  /*跳转到主题列表*/
  // onThemesItemTap: function (event) {
  //     var id = home.getDataSet(event, 'id');
  //     var name = home.getDataSet(event, 'name');
  //     wx.navigateTo({
  //         url: '../theme/theme?id=' + id+'&name='+ name
  //     })
  // },

  /*下拉刷新页面*/
  onPullDownRefresh: function() {
    this._loadData(() => {
      wx.stopPullDownRefresh()
    });
  },

  //分享效果
  onShareAppMessage: function() {
    return {
      title: '钟易小屋',
      path: 'pages/home/home'
    }
  },
  onCancelImgTap: function(event) {
    this.setData({
      containerShow: true,
      searchPanelShow: false,
      searchResult: {},
      inputValue: null
    })
  },
  onBindFocus: function(event) {
    this.setData({
      containerShow: false,
      searchPanelShow: true
    })
  },

  onBindConfirm: function(event) {
    var text = event.detail.value;
    this.setData({
      inputValue: text
    });

    /*搜索物品*/
    home.getProductorBySearch(text, (data) => {
      if(data.length>0){
        this.setData({
          searchResult: data
        });
      }else{
        this.setData({
          searchResult: {}
        });
      }
      // console.log(data.data.errCode);
      // if(data.data.errCode);
      
      // callback && callback();
    });

  }

})