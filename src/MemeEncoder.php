<?php

namespace App;

class MemeEncoder
{
    // 每个位置对应的梗文数组，每组至少64个，用于Base64编码
    private array $memeGroups = [
        // A-Z (0-25)
        [
            '绝了绝了', '笑死我了', '太牛了吧', '真的假的', '啊对对对', 
            '确实确实', '懂的都懂', '就是就是', '麻了麻了', '裂开了啦',
            '破防了呀', '寄了寄了', '太离谱了', '这么离谱', '太震惊了',
            '震惊倒了', '我都惊了', '这是否', '不是吧', '太可以了',
            '太强了', '我跪了', '我哭了', '太秀了', '太帅了', '太猛了'
        ],
        // a-z (26-51)
        [
            '不过呢', '但是呢', '所以说', '接着说', '然后呢', '后来呢',
            '继续说', '说下去', '你猜啊', '你说呢', '想不到', '没想到',
            '真的是', '属于是', '就是说', '我觉得', '确实是', '这就是',
            '简直是', '就像是', '其实是', '应该是', '可能是', '大概是',
            '或许是', '肯定是'
        ],
        // 0-9 (52-61)
        [
            '笑死', '破防', '裂开', '社死', '起飞', '爆炸', 
            '震惊', '狂喜', '无敌', '上天'
        ],
        // +/ (62-63)
        [
            '冲鸭', '带飞'
        ],
        // 额外的梗文，用于随机替换
        'extra' => [
            '完蛋', '崩溃', '自闭', '自爆', '暴毙', '跪了', '吐了', '呕吐',
            '哈人', '离谱', '绝了', '牛啊', '啊这', '好家伙', '芜湖', '起飞',
            '太上头了', '我酸了', '我裂开了', '我暴毙了', '我自闭了', '我傻了',
            '太草了', '太狠了', '太难崩了', '太难蚌了', '太难绷了', '太难顶了',
            '我超', '我哭死', '我吐了', '我服了', '我没了', '我裂开',
            '我直接好家伙', '我直接爆炸', '我直接裂开', '我直接震惊',
            '这河里吗', '这不河里', '这很河里', '这太河里了',
            '给我整不会了', '给我整笑了', '给我整哭了', '给我整懵了',
            '蚌埠住了', '绷不住了', '顶不住了', '受不了了',
            '典中典', '绝中绝', '离谱他妈给离谱开门', '离谱到家了',
            '你细品', '你仔细品', '你品你细品', '你回旋品',
            '这操作', '这波操作', '这手操作', '这套操作'
        ]
    ];

    /**
     * 将普通文本加密成梗文
     */
    public function encode(string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // 确保输入是UTF-8编码
        if (!mb_check_encoding($text, 'UTF-8')) {
            $text = mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text));
        }

        // 将文本转换为Base64
        $base64 = base64_encode($text);
        $result = [];
        
        // 将每个Base64字符转换为对应的梗文
        for ($i = 0; $i < strlen($base64); $i++) {
            $char = $base64[$i];
            if ($char === '=') {
                continue; // 跳过填充字符
            }
            
            $group = $this->getCharGroup($char);
            if ($group !== false) {
                // 使用基本组的梗文，确保一致性
                $memes = $this->memeGroups[$group];
                $index = $this->getCharIndex($char);
                if ($index !== false && isset($memes[$index])) {
                    $result[] = $memes[$index];
                }
            }
        }
        
        return implode('，', $result);
    }

    /**
     * 获取字符在其组内的索引
     * @return int|false
     */
    private function getCharIndex(string $char)
    {
        if ($char >= 'A' && $char <= 'Z') {
            return ord($char) - ord('A');
        }
        if ($char >= 'a' && $char <= 'z') {
            return ord($char) - ord('a');
        }
        if ($char >= '0' && $char <= '9') {
            return ord($char) - ord('0');
        }
        if ($char === '+') {
            return 0;
        }
        if ($char === '/') {
            return 1;
        }
        return false;
    }

    /**
     * 查找已映射到指定字符的额外梗文
     * @return array
     */
    private function findMappedExtraMemes(string $char): array
    {
        $mappedMemes = [];
        $group = $this->getCharGroup($char);
        $index = $this->getCharIndex($char);
        
        if ($group === false || $index === false) {
            return [];
        }

        // 在额外组中查找与基本组相同位置的梗文
        foreach ($this->memeGroups['extra'] as $meme) {
            foreach ($this->memeGroups as $groupIndex => $groupMemes) {
                if ($groupIndex === 'extra' || !is_array($groupMemes)) {
                    continue;
                }
                
                $memeIndex = array_search($meme, $groupMemes, true);
                if ($memeIndex !== false) {
                    if ($groupIndex === $group && $memeIndex === $index) {
                        $mappedMemes[] = $meme;
                    }
                }
            }
        }
        
        return $mappedMemes;
    }

    /**
     * 将梗文解密成普通文本
     */
    public function decode(string $memeText): string
    {
        if (empty($memeText)) {
            return '';
        }

        try {
            // 清理和分割输入文本
            $memeText = str_replace(['。', '，', ' ', '、', '！', '？', "\n", "\r"], '，', $memeText);
            $memeText = trim($memeText, '，');
            $parts = explode('，', $memeText);
            $parts = array_filter($parts, 'strlen');  // 移除空字符串
            
            if (empty($parts)) {
                return '解密失败：无效的输入格式';
            }
            
            // 将每个梗文转换回Base64字符
            $base64Chars = [];
            $failedMemes = [];
            
            foreach ($parts as $position => $meme) {
                $meme = trim($meme);
                if (empty($meme)) continue;
                
                // 优先在基本组中查找
                $char = $this->findMemeCharInBasicGroups($meme);
                
                if ($char !== false) {
                    $base64Chars[$position] = $char;
                } else {
                    $failedMemes[] = $meme;
                }
            }
            
            // 按正确顺序组合Base64字符
            ksort($base64Chars);
            $base64 = implode('', $base64Chars);
            
            if (empty($base64)) {
                if (!empty($failedMemes)) {
                    return '解密失败：无法识别的梗文：' . implode('，', $failedMemes);
                }
                return '解密失败：无法生成有效的Base64字符串';
            }
            
            // 补充缺失的填充字符
            $padding = strlen($base64) % 4;
            if ($padding > 0) {
                $base64 .= str_repeat('=', 4 - $padding);
            }
            
            // 尝试解码
            $decoded = base64_decode($base64);
            if ($decoded === false) {
                return '解密失败：无效的Base64编码：' . $base64;
            }
            
            // 确保结果是有效的UTF-8
            if (!mb_check_encoding($decoded, 'UTF-8')) {
                // 尝试转换编码
                $detected = mb_detect_encoding($decoded, ['UTF-8', 'GBK', 'GB2312', 'BIG5']);
                if ($detected) {
                    $decoded = mb_convert_encoding($decoded, 'UTF-8', $detected);
                }
                
                if (!mb_check_encoding($decoded, 'UTF-8')) {
                    return '解密失败：解码结果不是有效的UTF-8文本';
                }
            }
            
            return $decoded;
        } catch (\Exception $e) {
            return '解密失败：' . $e->getMessage();
        }
    }

    /**
     * 在基本组中查找梗文对应的字符
     * @param string $meme 要查找的梗文
     * @return string|false 找到返回Base64字符，否则返回false
     */
    private function findMemeCharInBasicGroups(string $meme)
    {
        $meme = trim($meme);
        if (empty($meme)) {
            return false;
        }

        // 在基本组中查找
        foreach ($this->memeGroups as $groupIndex => $group) {
            if ($groupIndex === 'extra' || !is_array($group)) {
                continue;
            }

            $index = array_search($meme, $group, true);
            if ($index !== false) {
                if ($groupIndex === 0 && $index < 26) {
                    return chr(ord('A') + $index);
                } elseif ($groupIndex === 1 && $index < 26) {
                    return chr(ord('a') + $index);
                } elseif ($groupIndex === 2 && $index < 10) {
                    return chr(ord('0') + $index);
                } elseif ($groupIndex === 3) {
                    return $index === 0 ? '+' : '/';
                }
            }
        }

        return false;
    }

    /**
     * 在额外组中查找梗文对应的字符
     * @param string $meme 要查找的梗文
     * @return string|false 找到返回Base64字符，否则返回false
     */
    private function findMemeCharInExtraGroup(string $meme)
    {
        // 在额外组中查找
        $index = array_search($meme, $this->memeGroups['extra'], true);
        if ($index !== false) {
            // 找到后，检查这个梗文是否在基本组中有对应
            foreach ($this->memeGroups as $groupIndex => $group) {
                if ($groupIndex === 'extra' || !is_array($group)) {
                    continue;
                }

                if (in_array($meme, $group, true)) {
                    $originalIndex = array_search($meme, $group, true);
                    if ($originalIndex !== false) {
                        if ($groupIndex === 0 && $originalIndex < 26) {
                            return chr(ord('A') + $originalIndex);
                        } elseif ($groupIndex === 1 && $originalIndex < 26) {
                            return chr(ord('a') + $originalIndex);
                        } elseif ($groupIndex === 2 && $originalIndex < 10) {
                            return chr(ord('0') + $originalIndex);
                        } elseif ($groupIndex === 3) {
                            return $originalIndex === 0 ? '+' : '/';
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * 获取字符所属的组
     * @param string $char 要查找的字符
     * @return int|false 找到返回组索引，否则返回false
     */
    private function getCharGroup(string $char)
    {
        if ($char >= 'A' && $char <= 'Z') {
            return 0;
        }
        if ($char >= 'a' && $char <= 'z') {
            return 1;
        }
        if ($char >= '0' && $char <= '9') {
            return 2;
        }
        if ($char === '+' || $char === '/') {
            return 3;
        }
        return false;
    }

    /**
     * 查找梗文对应的Base64字符
     * @param string $meme 要查找的梗文
     * @return string|false 找到返回Base64字符，否则返回false
     */
    private function findMemeChar(string $meme)
    {
        $meme = trim($meme);
        if (empty($meme)) {
            return false;
        }

        // 在A-Z组中查找
        $index = array_search($meme, $this->memeGroups[0], true);
        if ($index !== false && $index < 26) {
            return chr(ord('A') + $index);
        }
        
        // 在a-z组中查找
        $index = array_search($meme, $this->memeGroups[1], true);
        if ($index !== false && $index < 26) {
            return chr(ord('a') + $index);
        }
        
        // 在0-9组中查找
        $index = array_search($meme, $this->memeGroups[2], true);
        if ($index !== false && $index < 10) {
            return chr(ord('0') + $index);
        }
        
        // 在+/组中查找
        $index = array_search($meme, $this->memeGroups[3], true);
        if ($index !== false) {
            return $index === 0 ? '+' : '/';
        }
        
        // 在额外组中查找对应的原始梗文
        $index = array_search($meme, $this->memeGroups['extra'], true);
        if ($index !== false) {
            // 找到原始梗文后，在基本组中查找对应位置
            foreach ($this->memeGroups as $groupIndex => $group) {
                if ($groupIndex === 'extra') continue;
                if (!is_array($group)) continue;
                
                $originalIndex = array_search($meme, $group, true);
                if ($originalIndex !== false) {
                    if ($groupIndex === 0 && $originalIndex < 26) {
                        return chr(ord('A') + $originalIndex);
                    } elseif ($groupIndex === 1 && $originalIndex < 26) {
                        return chr(ord('a') + $originalIndex);
                    } elseif ($groupIndex === 2 && $originalIndex < 10) {
                        return chr(ord('0') + $originalIndex);
                    } elseif ($groupIndex === 3) {
                        return $originalIndex === 0 ? '+' : '/';
                    }
                }
            }
        }
        
        return false;
    }
} 