import {
  Order
} from '../order/order-model.js';
import {
  Cart
} from '../cart/cart-model.js';
import {
  Address
} from '../../utils/address.js';
import {
  Product
} from '../product/product-model.js';
import {
  Token
} from '../../utils/token.js';

var order = new Order();
var cart = new Cart();
var address = new Address();
var product = new Product();
var token = new Token();

Page({
  data: {
    fromCartFlag: true,
    addressInfo: null,
    user_id: 0,
    userProducts: []
  },

  /*
   * 换购数据来源包括两个：
   * 1.换物车下单
   * 2.旧的订单
   * */
  onLoad: function(options) {
    var flag = options.from == 'cart',
      that = this;
    this.data.fromCartFlag = flag;
    this.data.account = options.account;

    //来自于购物车
    if (flag) {
      this.setData({
        productsArr: cart.getCartDataFromLocal(true),
        account: options.account,
        orderStatus: 0
      });

      /*显示收获地址*/
      address.getAddress((res) => {
        that._bindAddressInfo(res);
      });
    }

    //旧订单
    else {
      this.data.id = options.id;
    }
  },

  onShow: function() {
    var user_id = token.userinfo();
    product.getUserProducts(user_id, (products) => {
      if (products) {
        for (var i = 0; i < products.length; i++) {
          products[i].selectStatus = false;
        }
        this.setData({
          userProducts: products,
          user_id: user_id
        });
      }

    });
    if (this.data.id) {
      var that = this;
      //下单后，支付成功或者失败后，点左上角返回时能够更新订单状态 所以放在onshow中
      var id = this.data.id;
      order.getOrderInfoById(id, (data) => {
        that.setData({
          orderStatus: data.status,
          productsArr: data.snap_items,
          account: data.total_price,
          basicInfo: {
            orderTime: data.create_time,
            orderNo: data.order_no
          },
        });

        // 快照地址
        var addressInfo = data.snap_address;
        addressInfo.totalDetail = address.setAddressInfo(addressInfo);
        that._bindAddressInfo(addressInfo);
      });
    }
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
        // 地址信息数据绑定
        that._bindAddressInfo(addressInfo);
        console.log(addressInfo);
        //保存地址
        address.submitAddress(res, (flag) => {
          if (!flag) {
            that.showTips('操作提示', '地址信息更新失败！');
          }
        });
      }
    })
  },

  /*绑定地址信息*/
  _bindAddressInfo: function(addressInfo) {
    this.setData({
      addressInfo: addressInfo
    });
  },

  /*下单和付款*/
  pay: function() {
    var num = 0;
    if (!this.data.addressInfo) {
      this.showTips('下单提示', '请填写您的收货地址');
      return;
    }

    if (!this.data.userProducts) {
      this.showTips('下单提示', '您的个人仓库为空！');
      return;
    }

    for (let i = 0; i < this.data.userProducts.length; i++) {
      if (this.data.userProducts[i].selectStatus) {
        num++;
      }
    }
    if (num == 0) {
      this.showTips('换购失败', '您至少需要选择一个物品！');
      return;
    }

    if (this.data.orderStatus == 0) {
      this._firstTimePayModify();
    } else {
      this._oneMoresTimePay();
    }
  },

  /*修改 第一次换物*/
  _firstTimePayModify: function() {
    var orderInfo = [],
      chooseInfo = [],
      postData = [],
      procuctInfo = this.data.productsArr,
      chooseProduct = this.data.userProducts,
      order = new Order();
    for (let i = 0; i < procuctInfo.length; i++) {
      orderInfo.push(procuctInfo[i].id);
    }
    for (let i = 0; i < chooseProduct.length; i++) {
      if (chooseProduct[i].selectStatus) {
        chooseInfo.push(chooseProduct[i].id);
      }
    }
   
    var that = this;
    //支付分两步，第一步是生成订单号，然后根据订单号支付
    order.doOrder2(orderInfo, chooseInfo, (data) => {
      return;
      //订单生成成功
      if (data.pass) {
        //更新订单状态
        var id = data.order_id;
        that.data.id = id;
        that.data.fromCartFlag = false;

        //开始支付
        that._execPay(id);
      } else {
        that._orderFail(data); // 下单失败
      }
    });
  },
  /*第一次支付*/
  _firstTimePay: function() {
    var orderInfo = [],
      procuctInfo = this.data.productsArr,
      order = new Order();
    for (let i = 0; i < procuctInfo.length; i++) {
      orderInfo.push({
        product_id: procuctInfo[i].id,
        count: procuctInfo[i].counts
      });
    }

    var that = this;
    //支付分两步，第一步是生成订单号，然后根据订单号支付
    order.doOrder(orderInfo, (data) => {
      //订单生成成功
      if (data.pass) {
        //更新订单状态
        var id = data.order_id;
        that.data.id = id;
        that.data.fromCartFlag = false;

        //开始支付
        that._execPay(id);
      } else {
        that._orderFail(data); // 下单失败
      }
    });
  },


  /*
   * 提示窗口
   * params:
   * title - {string}标题
   * content - {string}内容
   * flag - {bool}是否跳转到 "我的页面"
   */
  showTips: function(title, content, flag) {
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success: function(res) {
        if (flag) {
          wx.switchTab({
            url: '/pages/my/my'
          });
        }
      }
    });
  },

  /*
   *下单失败
   * params:
   * data - {obj} 订单结果信息
   * */
  _orderFail: function(data) {
    var nameArr = [],
      name = '',
      str = '',
      pArr = data.pStatusArray;
    for (let i = 0; i < pArr.length; i++) {
      if (!pArr[i].haveStock) {
        name = pArr[i].name;
        if (name.length > 15) {
          name = name.substr(0, 12) + '...';
        }
        nameArr.push(name);
        if (nameArr.length >= 2) {
          break;
        }
      }
    }
    str += nameArr.join('、');
    if (nameArr.length > 2) {
      str += ' 等';
    }
    str += ' 缺货';
    wx.showModal({
      title: '下单失败',
      content: str,
      showCancel: false,
      success: function(res) {

      }
    });
  },

  /* 再次次支付*/
  _oneMoresTimePay: function() {
    this._execPay(this.data.id);
  },

  /*
   *开始支付
   * params:
   * id - {int}订单id
   */
  _execPay: function(id) {
    if (!order.onPay) {
      this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽', true); //屏蔽支付，提示
      this.deleteProducts(); //将已经下单的商品从购物车删除
      return;
    }
    var that = this;
    order.execPay(id, (statusCode) => {
      if (statusCode != 0) {
        that.deleteProducts(); //将已经下单的商品从购物车删除   当状态为0时，表示

        var flag = statusCode == 2;
        wx.navigateTo({
          url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=order'
        });
      }
    });
  },

  //将已经下单的商品从购物车删除
  deleteProducts: function() {
    var ids = [],
      arr = this.data.productsArr;
    for (let i = 0; i < arr.length; i++) {
      ids.push(arr[i].id);
    }
    cart.delete(ids);
  },

  /*选择商品*/
  toggleSelect: function(event) {
    var id = cart.getDataSet(event, 'id'),
      status = cart.getDataSet(event, 'status'),
      index = this._getProductIndexById(id);
    this.data.userProducts[index].selectStatus = !status;
    this.setData({
      userProducts: this.data.userProducts
    });
  },

  /*根据商品id得到 商品所在下标*/
  _getProductIndexById: function(id) {
    var data = this.data.userProducts,
      len = data.length;
    for (let i = 0; i < len; i++) {
      if (data[i].id == id) {
        return i;
      }
    }
  }


})