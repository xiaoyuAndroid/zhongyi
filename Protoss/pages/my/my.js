import {
  Address
} from '../../utils/address.js';
import {
  Order
} from '../order/order-model.js';
import {
  My
} from '../my/my-model.js';
import {
  Product
} from '../product/product-model.js';
import {
  Token
} from '../../utils/token.js';

var address = new Address();
var order = new Order();
var my = new My();
var product = new Product();
var token = new Token();

Page({
  data: {
    pageIndex: 1,
    isLoadedAll: false,
    // loadingHidden:false,
    loadingHidden: true,
    orderArr: [],
    addressInfo: null,
    user_id: 0,
    userProducts: []
  },
  onLoad: function() {

  },

  onShow: function() {
    // this._loadData();
    this._loadData2();
    this._getAddressInfo();

    var user_id = token.userinfo();
    product.getUserProducts2(user_id, (products) => {
      if (products) {
        // for (var i = 0; i < products.length; i++) {
        //   products[i].selectStatus = false;
        // }
        this.setData({
          userProducts: products,
          user_id: user_id,
          loadingHidden: true
        });
      }
    });

    // //更新订单,相当自动下拉刷新,只有  非第一次打开 “我的”页面，且有新的订单时 才调用。
    // var newOrderFlag=order.hasNewOrder();
    // if(this.data.loadingHidden &&newOrderFlag){
    //     this.onPullDownRefresh();
    // }


  },

  _loadData2: function () {
    var that = this;
    my.getUserInfo((data) => {
      that.setData({
        showAuth: !data.auth,
        userInfo: data.userInfo
      })
    });
  },

  /**
   * 获取用户信息按钮回调事件
   */
  getUserInfo(event) {
    const {
      nickName,
      avatarUrl
    } = event.detail.userInfo
    this.setData({
      showAuth: false,
      userInfo: {
        nickName,
        avatarUrl
      }
    })
  },

  _loadData: function() {
    var that = this;
    this._getOrders();
    order.execSetStorageSync(false); //更新标志位
  },

  /**地址信息**/
  _getAddressInfo: function() {
    var that = this;
    address.getAddress((addressInfo) => {
      that._bindAddressInfo(addressInfo);
    });
  },

  /*修改或者添加地址信息*/
  editAddress: function() {
    var that = this;
    wx.chooseAddress({
      success: function(res) {
        var addressInfo = {
          name: res.userName,
          mobile: res.telNumber,
          totalDetail: address.setAddressInfo(res)
        };
        if (res.telNumber) {
          that._bindAddressInfo(addressInfo);
          //保存地址
          address.submitAddress(res, (flag) => {
            if (!flag) {
              that.showTips('操作提示', '地址信息更新失败！');
            }
          });
        }
        //模拟器上使用
        else {
          that.showTips('操作提示', '地址信息更新失败,手机号码信息为空！');
        }
      }
    })
  },

  onProductsStatus: function(event) {
    var id = event.target.dataset.id;
    var status = event.target.dataset.status;
    var shangjia = false;
    var that = this;

    if (status == 1) {
      shangjia = true;
    }

    product.editStatus(id, shangjia, (res) => {
      if (res == true) {
        var user_id = token.userinfo();
        product.getUserProducts2(user_id, (products) => {
          if (products) {

            this.setData({
              userProducts: products,
              user_id: user_id,
              loadingHidden: true
            });
          }
        });
      } else {
        console.log('1');
      }

    });

  },

  /*绑定地址信息*/
  _bindAddressInfo: function(addressInfo) {
    this.setData({
      addressInfo: addressInfo
    });
  },

  /*订单信息*/
  _getOrders: function(callback) {
    var that = this;
    order.getOrders(this.data.pageIndex, (res) => {
      var data = res.data;
      that.setData({
        loadingHidden: true
      });
      if (data.length > 0) {
        that.data.orderArr.push.apply(that.data.orderArr, res.data); //数组合并
        that.setData({
          orderArr: that.data.orderArr
        });
      } else {
        that.data.isLoadedAll = true; //已经全部加载完毕
        that.data.pageIndex = 1;
      }
      callback && callback();
    });
  },

  /*显示订单的具体信息*/
  showOrderDetailInfo: function(event) {
    var id = order.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../order/order?from=order&id=' + id
    });
  },

  /*未支付订单再次支付*/
  rePay: function(event) {
    var id = order.getDataSet(event, 'id'),
      index = order.getDataSet(event, 'index');

    //online 上线实例，屏蔽支付功能
    if (order.onPay) {
      this._execPay(id, index);
    } else {
      this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽');
    }
  },

  /*支付*/
  _execPay: function(id, index) {
    var that = this;
    order.execPay(id, (statusCode) => {
      if (statusCode > 0) {
        var flag = statusCode == 2;

        //更新订单显示状态
        if (flag) {
          that.data.orderArr[index].status = 2;
          that.setData({
            orderArr: that.data.orderArr
          });
        }

        //跳转到 成功页面
        wx.navigateTo({
          url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=my'
        });
      } else {
        that.showTips('支付失败', '商品已下架或库存不足');
      }
    });
  },

  /*下拉刷新页面*/
  onPullDownRefresh: function() {
    var that = this;
    this.data.orderArr = []; //订单初始化
    this._getOrders(() => {
      that.data.isLoadedAll = false; //是否加载完全
      that.data.pageIndex = 1;
      wx.stopPullDownRefresh();
      order.execSetStorageSync(false); //更新标志位
    });
  },


  onReachBottom: function() {
    if (!this.data.isLoadedAll) {
      this.data.pageIndex++;
      this._getOrders();
    }
  },

  /*
   * 提示窗口
   * params:
   * title - {string}标题
   * content - {string}内容
   * flag - {bool}是否跳转到 "我的页面"
   */
  showTips: function(title, content) {
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success: function(res) {

      }
    });
  },

  /*跳转到商品详情*/
  onProductsItemTap: function(event) {
    var id = event.currentTarget.dataset['id']
    wx.navigateTo({
      url: '../product/product?id=' + id
    })
  },

  onProductsAddTap: function(event) {
    wx.navigateTo({
      url: '../add/add'
    })
  }

})