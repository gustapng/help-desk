import js from '@eslint/js'
import { defineConfigWithVueTs, vueTsConfigs } from '@vue/eslint-config-typescript'
import { globalIgnores } from 'eslint/config'
import prettierConfig from 'eslint-config-prettier'
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
import eslintPluginImport from 'eslint-plugin-import'
import prettierPlugin from 'eslint-plugin-prettier'
import eslintPluginUnusedImports from 'eslint-plugin-unused-imports'
import pluginVue from 'eslint-plugin-vue'

export default defineConfigWithVueTs(
  {
    name: 'app/files-to-lint',
    files: ['src/**/*.{ts,mts,tsx,vue}'],
  },

  globalIgnores([
    '**/dist/**',
    '**/dist-ssr/**',
    '**/coverage/**',
    '**/node_modules/**'
  ]),

  js.configs.recommended,
  pluginVue.configs['flat/essential'],
  vueTsConfigs.recommended,
  eslintPluginImport.flatConfigs.recommended,

  {
    plugins: {
      prettier: prettierPlugin,
      'unused-imports': eslintPluginUnusedImports,
    },

    settings: {
      'import/resolver': {
        typescript: {
          alwaysTryTypes: true,
          project: './tsconfig.json'
        },
        node: {
          extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue'],
        },
      },
    },

    rules: {
      'vue/multi-word-component-names': 'off',
      'vue/no-mutating-props': 'error',
      'vue/no-unused-components': 'warn',
      'vue/html-self-closing': [
        'error',
        {
          html: {
            void: 'always',
            normal: 'never',
            component: 'always',
          },
        },
      ],

      'no-console': ['warn', { allow: ['warn', 'error'] }],
      'no-debugger': 'warn',
      'no-unused-vars': 'off',
      '@typescript-eslint/no-unused-vars': 'off',
      'unused-imports/no-unused-imports': 'error',
      'unused-imports/no-unused-vars': [
        'warn',
        { vars: 'all', varsIgnorePattern: '^_', args: 'after-used', argsIgnorePattern: '^_' },
      ],

      'import/order': [
        'error',
        {
          groups: [['builtin', 'external'], ['internal'], ['parent', 'sibling', 'index']],
          'newlines-between': 'always',
          alphabetize: { order: 'asc', caseInsensitive: true },
        },
      ],

      'max-len': ['warn', { code: 100, ignoreUrls: true }],
      'prefer-const': 'error',
      eqeqeq: ['error', 'always'],
      curly: ['error', 'all'],

      'prettier/prettier': ['error', {}, { usePrettierrc: true }],
    },
  },

  prettierConfig
)
