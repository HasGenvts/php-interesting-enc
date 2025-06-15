# 🎭 PHP-Interesting-Enc

[![GitHub stars](https://img.shields.io/github/stars/HasGenvts/php-interesting-enc.svg?style=social&label=Stars)](https://github.com/HasGenvts/php-interesting-enc)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue.svg)](https://www.php.net)
[![License](https://img.shields.io/github/license/HasGenvts/php-interesting-enc.svg)](LICENSE)

> 一个有趣的PHP加密工具，可以将普通文本转换成中文互联网流行梗，支持双向转换。

## 📈 项目活跃度

![Stargazers over time](https://starchart.cc/HasGenvts/php-interesting-enc.svg)

## ✨ 特性

- 🔄 支持文本与互联网梗的双向转换
- 🎯 使用确定性随机算法，相同输入产生不同但可解密的输出
- 📚 内置500+个中文互联网流行梗
- 🌈 支持常用汉字、标点符号的梗化转换
- 💻 简单易用的Web界面
- 🔧 可扩展的梗词库

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
// 让我康康
// 这不比
// 但是转念一想
// 太顶了
// 说起来你可能不信
// 离大谱
// 我想起来了
// 啊这
// 完事了
```

### 解密文本
```php
$encoder = new App\MemeEncoder();
$decrypted = $encoder->decode($encrypted);
echo $decrypted; // 输出：这也太离谱了吧？
```

## 🗃️ 梗词库分类

- 常用汉字映射（20个字符 × 5个梗）
- 网络热词映射（20个字符 × 5个梗）
- 情感表达映射（10个字符 × 5个梗）
- 网络流行语映射（10个字符 × 5个梗）
- 标点符号映射（14个字符 × 5个梗）

## 🤝 贡献指南

欢迎贡献新的梗词！请按以下步骤：

1. Fork 本仓库
2. 创建新分支：`git checkout -b feature/new-memes`
3. 在 `src/MemeEncoder.php` 中的 `$memeMap` 添加新的梗
4. 提交更改：`git commit -am '添加新梗'`
5. 推送分支：`git push origin feature/new-memes`
6. 提交 Pull Request

## 📄 开源协议

本项目采用 MIT 协议开源，详见 [LICENSE](LICENSE) 文件。

## 🌟 Star 历史

[![Star History Chart](https://api.star-history.com/svg?repos=HasGenvts/php-interesting-enc&type=Date)](https://star-history.com/#HasGenvts/php-interesting-enc&Date)

## 📊 项目状态

![Alt](https://repobeats.axiom.co/api/embed/your-repobeats-hash.svg "Repobeats analytics image")

## 🙏 鸣谢

感谢所有为项目贡献梗的小伙伴们！

---
如果这个项目对你有帮助，欢迎 star ⭐️ 支持一下！