module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es6: true,
    jquery: true,
    mocha: true,
  },
  parserOptions: {
    parser: '@babel/eslint-parser',
  },
  plugins: [
    'import',
  ],
  extends: [
    'prestashop',
  ],
  rules: {
    'no-new': 0,
    'keyword-spacing': 0,
    'class-methods-use-this': 0,
  },
};
