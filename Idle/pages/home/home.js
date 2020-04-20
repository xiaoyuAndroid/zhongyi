// pages/home/home.js

import {Home} from 'home-model.js';
var home = new Home();

Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },

  _loadData:function(){
    var that = this;
    // 获得bannar信息
    home.getBannerData((data) => {
      that.setData({
        'bannerArr': data,
      });
    });

    /*获取主题信息*/
    home.getThemeData((data) => {
      that.setData({
        themeArr: data,
        // loadingHidden: true
      });
    });

    /*获取单品信息*/
    home.getProductorData((data) => {
      that.setData({
        productsArr: data
      });
      // callback && callback();
    });
  },


  /*跳转到商品详情*/
  onProductsItemTap: function (event) {
    // var id = home.getDataSet(event, 'id');
    var id = null;
    console.log(event);
    wx.navigateTo({
      url: '../product/product?id=' + id + '&nameTs=8'
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

  }
})