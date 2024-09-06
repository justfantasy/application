import { ConfigProvider } from '@arco-design/web-react';
import { Provider } from 'react-redux';
import { RouterProvider } from 'react-router-dom';
import { useLocalStorage } from 'react-use';

import { THEME_KEY } from '@/constants';
import { GlobalContext } from '@/contexts';
import router from '@/router';
import store from '@/store';

export default function App() {
  const [theme, setTheme] = useLocalStorage(THEME_KEY, 'light');
  const contextValue = {
    theme,
    setTheme,
  };

  // arco-design组件的一些通用配置
  const componentConfig = {
    Card: {
      bordered: false,
    },
    List: {
      bordered: false,
    },
    Table: {
      border: false,
    },
  };

  return (
    <Provider store={store}>
      <ConfigProvider componentConfig={componentConfig}>
        <GlobalContext.Provider value={contextValue}>
          <RouterProvider router={router} />
        </GlobalContext.Provider>
      </ConfigProvider>
    </Provider>
  );
}
