import { createContext } from 'react';

// 创建一个可全局读取的上下文，当前保存的内容为主题变更
export const GlobalContext = createContext<{
  theme?: string;
  setTheme?: (value: string) => void;
}>({});
