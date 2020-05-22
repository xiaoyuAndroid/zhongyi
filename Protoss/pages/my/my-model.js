/**
 * Created by jimmy on 17/3/24.
 */
import {
  Base
} from '../../utils/base.js'
import {
  Token
} from '../../utils/token.js';
var token = new Token();

class My extends Base {
  constructor() {
    super();
  }

  //得到用户信息
  getUserInfo(cb) {
    var that = this;
    wx.login({
      success: function() {
        wx.getUserInfo({
          success: function(res) {
            const data = {
              auth: true,
              userInfo: res.userInfo
            }
            typeof cb == "function" && cb(data);

            //将用户昵称 提交到服务器
            if (!that.onPay) {
              that._updateUserInfo(res.userInfo);
            }
            // console.log(res);

          },
          fail: function(res) {
            const data = {
              auth: false,
              userInfo: {
                avatarUrl: '../../imgs/icon/user@default.png',
                nickName: '点击获取用户信息'
              }
            }
            typeof cb == "function" && cb(data);
          }
        });
      },

    })
  }

  /*更新用户信息到服务器*/
  _updateUserInfo(res) {
    var user_id = token.userinfo();

    var nickName = res.nickName;
    delete res.avatarUrl; //将昵称去除
    delete res.nickName; //将昵称去除
    var allParams = {
      url: 'user/wx_info',
      data: {
        nickname: nickName,
        extend: JSON.stringify(res),
        user_id: user_id
      },
      type: 'post',
      sCallback: function(data) {}
    };
    this.request(allParams);

  }
}



export {
  My
}