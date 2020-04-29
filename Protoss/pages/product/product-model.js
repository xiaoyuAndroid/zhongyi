/**
 * Created by jimmy on 17/2/26.
 */

import {
  Base
} from '../../utils/base.js';

class Product extends Base {
  constructor() {
    super();
  }
  getDetailInfo(id, callback) {
    var param = {
      url: 'product/' + id,
      sCallback: function(data) {
        callback && callback(data);
      }
    };
    this.request(param);
  }

  editStatus(productid, status=false,callback){
    var zhongyiurl = null;
    if (status) {
      zhongyiurl = 'product/modify/' + productid + '?type=' + 'shangjia' + '&id=' + productid;
    } else {
      zhongyiurl = 'product/modify/' + productid + '?type=' + 'xiajia' + '&id=' + productid;
    }

    var param = {
      url:zhongyiurl,
      sCallback: function (data) {
        callback && callback(data);
      }
    };
    this.request(param);
  }

  getUserProducts(user_id, callback) {
    var param = {
      url: 'product/user_id/' + user_id,
      sCallback: function(data) {
        callback && callback(data);
      }
    };
    this.request(param);
  }

  getUserProducts2(user_id, callback) {
    var param = {
      url: 'product/user/' + user_id,
      sCallback: function (data) {
        callback && callback(data);
      }
    };
    this.request(param);
  }
};

export {
  Product
}