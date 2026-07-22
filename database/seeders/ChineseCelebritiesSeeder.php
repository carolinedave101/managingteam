<?php

namespace Database\Seeders;

class ChineseCelebritiesSeeder extends BaseCelebritySeeder
{
    private array $maleFirstNames = [
        'Wei', 'Ming', 'Jun', 'Lei', 'Qiang',
        'Hao', 'Peng', 'Kai', 'Long', 'Feng',
        'Zhi', 'Qing', 'Jian', 'Bin', 'Yong',
        'Gang', 'Tao', 'Yang', 'Xin', 'Chao',
        'Bo', 'Dong', 'Fei', 'Han', 'Hua',
        'Jie', 'Ke', 'Li', 'Min', 'Nan',
        'Ping', 'Qi', 'Rui', 'Shan', 'Tian',
        'Wen', 'Xiang', 'Xue', 'Yi', 'Ze',
        'Zhong', 'An', 'Chen', 'Da', 'En',
        'Fang', 'Guang', 'Hong', 'Jing', 'Kang',
        'Lin', 'Ma', 'Ning', 'Pei', 'Ran',
        'Song', 'Ting', 'Wang', 'Xia', 'Yan',
        'Zhen', 'Biao', 'Cheng', 'Deng', 'Fa',
        'Heng', 'Jia', 'Kun', 'Liang', 'Miao',
        'Niu', 'Ou', 'Shen', 'Teng', 'Wu',
        'Xi', 'Yuan', 'Zang', 'Bai', 'Chu',
        'Duan', 'Gao', 'Hou', 'Jin', 'Lan',
        'Meng', 'Pan', 'Rao', 'Su', 'Tang',
        'Wei', 'Xiao', 'Yu', 'Zheng', 'Chang',
    ];

    private array $femaleFirstNames = [
        'Mei', 'Li', 'Juan', 'Fang', 'Yan',
        'Lin', 'Hua', 'Xiu', 'Yun', 'Xia',
        'Qing', 'Ping', 'Na', 'Lan', 'Ying',
        'Hong', 'Rong', 'Ai', 'Jing', 'Ting',
        'Yue', 'Shuang', 'Wen', 'Dan', 'Xin',
        'Man', 'Qi', 'Wei', 'Yu', 'Shu',
        'Fen', 'Ling', 'Chen', 'Ming', 'Hui',
        'Xiang', 'Zhen', 'Di', 'Sha', 'Ning',
        'Fei', 'Rui', 'Lei', 'Tao', 'Yuan',
        'Zhou', 'Bai', 'Chun', 'Dong', 'Feng',
        'Ge', 'Hong', 'Jia', 'Ke', 'Lan',
        'Miao', 'Ni', 'Ou', 'Pei', 'Qian',
        'Ran', 'Sheng', 'Tian', 'Wan', 'Xuan',
        'Yan', 'Zhu', 'An', 'Bing', 'Cui',
        'Dan', 'E', 'Gai', 'Huan', 'Iris',
        'Jun', 'Kang', 'Ling', 'Min', 'Nan',
        'Ping', 'Qi', 'Rong', 'Shi', 'Tong',
        'Wu', 'Xian', 'Ying', 'Zhi', 'Chang',
        'Jie', 'Liang', 'Mei', 'Qian', 'Xia',
    ];

    private array $lastNames = [
        'Wang', 'Li', 'Zhang', 'Liu', 'Chen',
        'Yang', 'Zhao', 'Huang', 'Zhou', 'Wu',
        'Xu', 'Sun', 'Hu', 'Zhu', 'Gao',
        'Lin', 'He', 'Guo', 'Ma', 'Luo',
        'Liang', 'Song', 'Zheng', 'Xie', 'Han',
        'Tang', 'Feng', 'Cheng', 'Cai', 'Peng',
        'Pan', 'Yuan', 'Deng', 'Xu', 'Fu',
        'Shen', 'Zeng', 'Peng', 'Lu', 'Su',
        'Lu', 'Jiang', 'Jia', 'Ding', 'Wei',
        'Xue', 'Ye', 'Yan', 'Yu', 'Pan',
        'Du', 'Dai', 'Xia', 'Zhong', 'Wang',
        'Tian', 'Ren', 'Jiang', 'Fan', 'Fang',
        'Shi', 'Yao', 'Tan', 'Liao', 'Zou',
        'Xiong', 'Jin', 'Lu', 'Hao', 'Kong',
        'Bai', 'Cui', 'Kang', 'Mao', 'Qiu',
        'Qin', 'Jiang', 'Shi', 'Gu', 'Hou',
        'Shao', 'Meng', 'Long', 'Duan', 'Cao',
        'Qian', 'Yin', 'Chang', 'Li', 'Wen',
        'Qiao', 'Gong', 'Wan', 'Lan', 'Niu',
        'Hong', 'Sheng', 'Rao', 'Yan', 'Xiang',
        'Tong', 'Zhan', 'Mo', 'Lei', 'Pu',
        'Tie', 'Miao', 'Geng', 'Xi', 'You',
        'An', 'Ruan', 'Hou', 'Xiao', 'Qiu',
        'Dong', 'Tan', 'Ji', 'Sang', 'Yue',
        'Chai', 'Ning', 'Jie', 'Wu', 'Qu',
    ];

    public function run(): void
    {
        set_time_limit(0);
        $country = 'China';

        $this->command?->info("Seeding {$country}...");

        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 1000), 'movie_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 1000), 'movie_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 400), 'musician', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 400), 'musician', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 100), 'country_singer', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 100), 'country_singer', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'adult_star', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'adult_star', 'female', $country);
        $this->createCelebrities($this->generateNames($this->maleFirstNames, $this->lastNames, 250), 'general', 'male', $country);
        $this->createCelebrities($this->generateNames($this->femaleFirstNames, $this->lastNames, 250), 'general', 'female', $country);

        $this->command?->info("{$country} seeding complete.");
    }
}
