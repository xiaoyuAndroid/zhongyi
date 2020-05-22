// pages/add/add.js
import { Category } from '../category/category-model.js';
var category = new Category();  //实例化 home 的推荐页面
import { Base } from '../../utils/base.js';
var base = new Base();

import {Token} from '../../utils/token.js';
var token = new Token();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    categoryTypeArr:[],
    uploadArrData:[],
    user_id:0
  },

  formSubmit: function (e) {
    var that = this;
    var uploadData = e.detail.value;
    
    console.log(e);
    return;

    if(!uploadData.productName){
      wx.showModal({
        content: '名称不能为空',
        showCancel: false,
        success: function (res) {
        }
      });
      return;
    }


    if (!uploadData.uploadImage) {
      wx.showModal({
        content: '您还没有上传图片',
        showCancel: false,
        success: function (res) {
        }
      });
      return;
    }

    this.setData({
      uploadArrData: uploadData
    });

    wx.uploadFile({
      url: 'http://zhongyi.com/api/v1/product/add', //仅为示例，非真实的接口地址
      filePath: uploadData.uploadImage['0']['url'],
      name: 'image',
      formData: {
        'productName': uploadData.productName,
        'radioSelected': uploadData.radioSelected,
        'user_id':this.data.user_id
      },
      success(res) {
        if (res.data=='true'){
          that.showTips('','新增成功',true);
        }else{
          that.showTips('', '操作失败', true);
        }
      }
    });
  },

  formReset: function () {
    console.log('form发生了reset事件')
  },

  radioChange: function (e) {
    console.log('radio发生change事件，携带value值为：', e.detail.value)
  },
  

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var user_id = token.userinfo();
    this.data.user_id = user_id;
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    var that = this;
    category.getCategoryType((categoryData) => {
      categoryData['0']['checked'] = true;
      that.setData({
        categoryTypeArr: categoryData,
      });
    });
  },

  /*获得所有分类*/
  uploadData:function(param,callback) {
    var that = this;
    var allParams = {
      url: 'product/add',
      type: 'post',
      data: { addProduct: param },
      sCallback: function (data) {

        callback && callback(data);
      },
      eCallback: function () {
      }
    };
    base.request(allParams);
  },

  /*
 * 提示窗口
 * params:
 * title - {string}标题
 * content - {string}内容
 * flag - {bool}是否跳转到 "我的页面"
 */
  showTips: function (title, content, flag) {
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success: function (res) {
        if (flag) {
          wx.switchTab({
            url: '/pages/my/my'
          });
        }
      }
    });
  }


})