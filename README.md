# 🎭 PHP-Interesting-Enc

[![GitHub stars](https://img.shields.io/github/stars/HasGenvts/php-interesting-enc.svg?style=social&label=Stars)](https://github.com/HasGenvts/php-interesting-enc)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue.svg)](https://www.php.net)
[![License](https://img.shields.io/github/license/HasGenvts/php-interesting-enc.svg)](LICENSE)

> 一个有趣的PHP加密工具，可以将普通文本转换成中文互联网流行梗，支持双向转换。

## 📈 项目活跃度

![Stargazers over time](https://starchart.cc/HasGenvts/php-interesting-enc.svg)

## ✨ 特性

- 🔄 支持文本与互联网梗的双向转换
- 🎯 使用Base64编码结合梗文替换，确保加密可靠性
- 🎲 随机梗文替换，相同输入产生不同但可解密的输出
- 📚 内置100+个中文互联网流行梗，分组管理
- 🌈 支持任意UTF-8文本的梗化转换
- 💻 简单易用的Web界面
- 🔧 可扩展的分组梗词库

## 🎮 在线演示

访问 [Demo页面](https://your-demo-url.com) 体验文本加密解密效果。

## 🚀 快速开始

### 环境要求

- PHP >= 7.4
- Web服务器（Apache/Nginx）

### 安装

1. 克隆仓库：
```bash
git clone https://github.com/HasGenvts/php-interesting-enc.git
```

2. 进入项目目录：
```bash
cd php-interesting-enc
```

3. 安装依赖：
```bash
composer install
```

4. 启动开发服务器：
```bash
php -S localhost:8000
```

5. 访问 `http://localhost:8000` 开始使用

## 📝 使用示例

### 加密文本
```php
$encoder = new App\MemeEncoder();
$encrypted = $encoder->encode("这也太离谱了吧？");
echo $encrypted;

// 输出示例：
// 太离谱了，我直接好家伙，这不河里，
// 给我整笑了，蚌埠住了，太难绷了，
// 我直接震惊，你品你细品，这波操作
```

### 解密文本
```php
$encoder = new App\MemeEncoder();
$decrypted = $encoder->decode($encrypted);
echo $decrypted; // 输出：这也太离谱了吧？
```

## 🗃️ 梗词库分类

梗词库采用分组管理方式，包括：

- A-Z组（26个基础梗）：用于编码大写字母
- a-z组（26个基础梗）：用于编码小写字母
- 0-9组（10个基础梗）：用于编码数字
- 特殊字符组（2个基础梗）：用于编码特殊字符
- 额外梗组（50+个梗）：用于随机替换，增加趣味性

每个位置的梗文都可以被额外梗组的内容随机替换，使得相同的输入每次都能产生不同的、但可解密的输出。

## 🤝 贡献指南

欢迎贡献新的梗词！请按以下步骤：

1. Fork 本仓库
2. 创建新分支：`git checkout -b feature/new-memes`
3. 在 `src/MemeEncoder.php` 中的 `$memeGroups` 数组添加新的梗
4. 提交更改：`git commit -am '添加新梗'`
5. 推送分支：`git push origin feature/new-memes`
6. 提交 Pull Request

## 📄 开源协议

本项目采用 MIT 协议开源，详见 [LICENSE](LICENSE) 文件。

## 🌟 Star 历史

[![Star History Chart](https://api.star-history.com/svg?repos=HasGenvts/php-interesting-enc&type=Date)](https://star-history.com/#HasGenvts/php-interesting-enc&Date)


## 🙏 鸣谢

感谢所有为项目贡献梗的小伙伴们！

---
如果这个项目对你有帮助，欢迎 star ⭐️ 支持一下！
