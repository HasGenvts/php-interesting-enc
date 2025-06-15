<?php
// 直接引入类文件
require_once __DIR__ . '/src/MemeEncoder.php';

use App\MemeEncoder;

$encoder = new MemeEncoder();
$result = '';
$original = '';
$action = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'] ?? '';
    $action = $_POST['action'] ?? '';
    $original = $text;
    
    if ($action === 'encode') {
        $result = $encoder->encode($text);
    } elseif ($action === 'decode') {
        $result = $encoder->decode($text);
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>互联网梗加密器</title>
    <style>
        body {
            font-family: 'Microsoft YaHei', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }
        .buttons {
            text-align: center;
            margin: 20px 0;
        }
        button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            background: #1890ff;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #40a9ff;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background: #f8f8f8;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>互联网梗加密器</h1>
        <form method="post">
            <div>
                <textarea name="text" placeholder="请输入要处理的文本"><?php echo htmlspecialchars($original); ?></textarea>
            </div>
            <div class="buttons">
                <button type="submit" name="action" value="encode">加密成梗</button>
                <button type="submit" name="action" value="decode">解密成文本</button>
            </div>
        </form>
        <?php if ($result): ?>
        <div class="result">
            <h3><?php echo $action === 'encode' ? '加密结果' : '解密结果'; ?>：</h3>
            <p><?php echo htmlspecialchars($result); ?></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html> 