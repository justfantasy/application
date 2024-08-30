import {
  defineConfig,
  presetUno,
  presetAttributify,
  presetIcons,
} from 'unocss';

export default defineConfig({
  presets: [
    presetUno({ important: '#root' }), // 添加 UnoCSS 的默认样式预设
    presetAttributify(),
    presetIcons(),
  ],
});
