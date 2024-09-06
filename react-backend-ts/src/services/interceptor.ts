import axios from 'axios';
import { Message, Modal } from '@arco-design/web-react';
import { useUserStore } from '@/store';
import { getToken } from '@/utils/auth';

axios.defaults.baseURL = '/api/';

// 添加请求拦截器
axios.interceptors.request.use(
  (config) => {
    // 将jwt-token加入到请求头中
    const token = getToken();
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    // 若是post和put请求，修改为表单类型
    if (config.method && ['post', 'put'].includes(config.method)) {
      config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
    }

    return config;
  },
  (error) => {
    return Promise.reject(error);
  },
);

// 添加相应拦截器
axios.interceptors.response.use(
  (response) => {
    const res = response.data;
    // if the custom code is not 20000, it is judged as an error.
    if (res.code !== 20000) {
      Message.error({
        content: res.msg || 'Error',
        duration: 5 * 1000,
      });
      // 50008: Illegal token; 50012: Other clients logged in; 50014: Token expired;
      if (
        [50008, 50012, 50014].includes(res.code) &&
        response.config.url !== '/api/user/info'
      ) {
        Modal.error({
          title: 'Confirm logout',
          content:
            'You have been logged out, you can cancel to stay on this page, or log in again',
          okText: 'Re-Login',
          async onOk() {
            const userStore = useUserStore();

            await userStore.logout();
            window.location.reload();
          },
        });
      }
      return Promise.reject(new Error(res.msg || 'Error'));
    }
    return res;
  },
  (error) => {
    Message.error({
      content: error.msg || 'Request Error',
      duration: 5 * 1000,
    });
    return Promise.reject(error);
  },
);
