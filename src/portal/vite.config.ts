import { fileURLToPath, URL } from 'node:url'
import { readFileSync } from 'node:fs'
import path from 'path'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import {existsSync} from "fs";

const httpsConfig =
    existsSync('/etc/ssl/private/local.io.key')
        ? {
          key: readFileSync('/etc/ssl/private/local.io.key'),
          cert: readFileSync('/etc/ssl/private/local.io.crt'),
        }
        : false


// https://vitejs.dev/config/
export default defineConfig({
  server: {
    host: true,
    port: 8000,
    strictPort: true,
    https: httpsConfig,
    hmr: {
      port: 8000,
    },
  },
  preview: {
    host: true,
    port: 8000,
    https: httpsConfig,
  },
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './resources'),
      '@components': path.resolve(__dirname, './resources/components'),
      '@assets': path.resolve(__dirname, './resources/assets'),
    },
  },

})
