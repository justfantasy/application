import {
  defineConfig,
  presetAttributify,
  presetIcons,
  presetUno,
  transformerAttributifyJsx,
} from 'unocss';

export default defineConfig({
  presets: [
    presetUno({ important: '#root' }), // 添加 UnoCSS 的默认样式预设
    presetAttributify(),
    presetIcons(),
  ],
  transformers: [transformerAttributifyJsx()],
});
