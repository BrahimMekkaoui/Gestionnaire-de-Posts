module.exports = {
    root: true,
    parserOptions: {
        ecmaVersion: 2022,
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true,
            modules: true,
        },
    },
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:prettier/recommended',
    ],
    plugins: ['prettier'],
    rules: {
        'prettier/prettier': 'error',
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
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
