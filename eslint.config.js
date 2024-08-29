import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";
import pluginPrettier from "eslint-plugin-prettier";


export default [
    {files: ["**/*.{js,mjs,cjs,vue}"]},
    {languageOptions: { globals: globals.browser }},
    {
        ignores: ["**/node_modules/*", "**/dist/*", "**/public/build/*", "**/vendor/*"]
    },
    {rules : {
        "indent": ["error", 4]

    }
    },
    pluginJs.configs.recommended,
    ...pluginVue.configs["flat/recommended"],
    {
        plugins: {
            pluginPrettier
        }
    }
];
