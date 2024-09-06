import {
  Button,
  Checkbox,
  Form,
  FormInstance,
  Input,
  Space,
} from '@arco-design/web-react';
import { IconLock, IconUser } from '@arco-design/web-react/icon';
import { useLocalStorageState, useRequest } from 'ahooks';
import { useState } from 'react';

import { LOGIN_KEY } from '@/constants';
import { getUsername } from '@/services/auth.ts';

export default function LoginForm() {
  const [loginForm] = Form.useForm();
  const { error, loading, runAsync } = useRequest(getUsername, {
    manual: true,
  });
  const [loginParams, setLoginPrams] = useLocalStorageState(LOGIN_KEY, {
    defaultValue: {
      username: '',
      password: '',
    },
  });

  const [rememberPassword, setRememberPassword] = useState(
    !!loginParams?.username,
  );

  const afterLoginSuccess = () => {
    if (rememberPassword) {
      setLoginPrams(loginForm.getFieldsValue());
    } else {
      setLoginPrams();
    }
  };

  const login = async (params) => {
    try {
      await runAsync(params);
      afterLoginSuccess();
    } catch (err) {
      console.log(err.message);
    }
  };

  const onSubmit = async () => {
    loginForm.validate().then((values) => {
      login(values);
    });
  };

  return (
    <div className="w-80">
      <div className="text-[--color-text-1] font-medium text-2xl mb-4 text-center">
        Will Admin管理后台
      </div>
      <div className="h-8 leading-8 text-[rgba(var(--red-6))]">
        {error?.message}
      </div>
      <Form layout="vertical" form={loginForm as FormInstance}>
        <Form.Item
          field="username"
          initialValue={loginParams?.username}
          rules={[{ required: true, message: '用户名不能为空' }]}
        >
          <Input
            prefix={<IconUser />}
            placeholder="请输入用户名"
            onPressEnter={onSubmit}
          />
        </Form.Item>
        <Form.Item
          field="password"
          initialValue={loginParams?.password}
          rules={[{ required: true, message: '密码不能为空' }]}
        >
          <Input.Password
            prefix={<IconLock />}
            placeholder="请输入密码"
            onPressEnter={onSubmit}
            autoComplete="off"
          />
        </Form.Item>
        <Space size={16} direction="vertical">
          <div>
            <Checkbox checked={rememberPassword} onChange={setRememberPassword}>
              记住密码
            </Checkbox>
          </div>
          <Button type="primary" long onClick={onSubmit} loading={loading}>
            登录
          </Button>
        </Space>
      </Form>
    </div>
  );
}
