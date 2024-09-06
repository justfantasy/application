import { Layout } from '@arco-design/web-react';

import LoginBanner from '@/pages/Login/components/Banner.tsx';
import LoginForm from '@/pages/Login/components/Form.tsx';

import styles from './style/index.module.scss';

function Login() {
  return (
    <div flex h-screen className={styles.container}>
      <LoginBanner />
      <div relative flex items-center justify-center className="flex-1 pb-10">
        <div className="content-inner">
          <LoginForm />
        </div>
        <div absolute className="right-0 bottom-0 w-full">
          <Layout.Footer
            flex
            items-center
            justify-center
            className="h-10 text-center text-[--color-text-2]"
          >
            风吟鸣涧工作室
          </Layout.Footer>
        </div>
      </div>
    </div>
  );
}

Login.displayName = 'loginPage';

export default Login;
