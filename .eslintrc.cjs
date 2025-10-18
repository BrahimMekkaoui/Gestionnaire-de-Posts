module.exports = {
    root: true,
    parser: 'vue-eslint-parser',
    parserOptions: {
        parser: '@babel/eslint-parser',
        ecmaVersion: 2022,
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true,
            modules: true,
        },
        requireConfigFile: false,
    },
    env: {
        browser: true,
        es2021: true,
        node: true,
        'vue/setup-compiler-macros': true,
    },
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
        'plugin:prettier/recommended',
    ],
    plugins: ['vue', 'prettier'],
    rules: {
        'prettier/prettier': 'error',
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'vue/multi-word-component-names': 'off',
        'vue/component-name-in-template-casing': ['error', 'PascalCase'],
        'vue/attribute-hyphenation': ['error', 'always'],
        'vue/require-default-prop': 'off',
        'vue/require-prop-types': 'error',
        'vue/order-in-components': 'error',
        'vue/attributes-order': 'error',
        'vue/component-tags-order': [
            'error',
            {
                order: ['script', 'template', 'style'],
            },
        ],
    },
    settings: {
        'import/resolver': {
            alias: {
                map: [['@', './resources/js']],
                extensions: ['.js', '.vue', '.json'],
            },
        },
    },
    overrides: [
        {
            files: ['**/__tests__/*.{j,t}s?(x)', '**/tests/unit/**/*.spec.{j,t}s?(x)'],
            env: {
                jest: true,
            },
        },
    ],
};
