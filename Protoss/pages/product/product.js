// var productObj = require('product-model.js');

import {
  Product
} from 'product-model.js';
import {
  Cart
} from '../cart/cart-model.js';

import {
  Token
} from '../../utils/token.js';

var product = new Product(); //实例化 商品详情 对象
var cart = new Cart();
var token = new Token();
Page({
  data: {
    loadingHidden: false,
    hiddenSmallImg: true,
    countsArray: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    productCounts: 1,
    currentTabsIndex: 0,
    cartTotalCounts: 0,
    user_id: 0,
  },
  onLoad: function(option) {
    var id = option.id;
    this.data.id = id;
    this._loadData();
    var user_id = token.userinfo();
    this.data.user_id = user_id;
  },

  /*加载所有数据*/
  _loadData: function(callback) {
    var that = this;
    product.getDetailInfo(this.data.id, (data) => {
      that.setData({
        cartTotalCounts: cart.getCartTotalCounts().counts1,
        product: data,
        loadingHidden: true
      });
      callback && callback();
    });
  },

  //选择购买数目
  bindPickerChange: function(e) {
    this.setData({
      productCounts: this.data.countsArray[e.detail.value],
    })
  },

  //切换详情面板
  onTabsItemTap: function(event) {
    var index = product.getDataSet(event, 'index');
    this.setData({
      currentTabsIndex: index
    });
  },

  /*添加到购物车*/
  onAddingToCartTap: function(events) {
    //防止快速点击
    if (this.data.isFly) {
      return;
    }

    var cartData = cart.getCartDataFromLocal();
    if (cartData.length >= 1) {
      this.showTips('注意', '一次只能换购一个物品！您现在要先去换购车处理吗？', true, true);
      return;
    }
    // console.log(this.data.product);

    if (this.data.user_id == this.data.product.user_id) {
      this.showTips('', '物品【'+this.data.product.name+'】是您本人发布的', false, false);
      return;
    }

    // console.log('ceshi');

    this._flyToCartEffect(events);
    this.addToCart();
  },

  /*将商品数据添加到内存中*/
  addToCart: function() {
    var tempObj = {},
      keys = ['id', 'name', 'main_img_url', 'price'];
    for (var key in this.data.product) {
      if (keys.indexOf(key) >= 0) {
        tempObj[key] = this.data.product[key];
      }
    }

    cart.add(tempObj, this.data.productCounts);
  },

  /*加入购物车动效*/
  _flyToCartEffect: function(events) {
    //获得当前点击的位置，距离可视区域左上角
    var touches = events.touches[0];
    var diff = {
        x: '25px',
        y: 25 - touches.clientY + 'px'
      },
      style = 'display: block;-webkit-transform:translate(' + diff.x + ',' + diff.y + ') rotate(350deg) scale(0)'; //移动距离
    this.setData({
      isFly: true,
      translateStyle: style
    });
    var that = this;
    setTimeout(() => {
      that.setData({
        isFly: false,
        translateStyle: '-webkit-transform: none;', //恢复到最初状态
        isShake: true,
      });
      setTimeout(() => {
        var counts = that.data.cartTotalCounts + that.data.productCounts;
        that.setData({
          isShake: false,
          cartTotalCounts: counts
        });
      }, 200);
    }, 1000);
  },

  /*跳转到购物车*/
  onCartTap: function() {
    wx.switchTab({
      url: '/pages/cart/cart'
    });
  },

  /*下拉刷新页面*/
  onPullDownRefresh: function() {
    this._loadData(() => {
      wx.stopPullDownRefresh()
    });
  },

  //分享效果
  onShareAppMessage: function() {
    return {
      title: '零食商贩 Pretty Vendor',
      path: 'pages/product/product?id=' + this.data.id
    }
  },

  /*
   * 提示窗口
   * params:
   * title - {string}标题
   * content - {string}内容
   * flag - {bool}是否跳转到 "换物车页面"
   * 
   * this.showTips('1','2',true);
   * this.showTips('', '这个商品是您本人上架的，不能换购',false,false);

   */
  showTips: function(title, content, showCancel, flag) {
    wx.showModal({
      title: title,
      content: content,
      showCancel: showCancel,
      success: function(res) {
        if (res.confirm) {
          if (flag) {
            wx.switchTab({
              url: '/pages/cart/cart'
            });
          }
        } else {

        }
      }
    });
  }

})