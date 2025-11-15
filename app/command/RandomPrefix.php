<?php
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;

class RandomPrefix extends Command
{
    protected function configure()
    {
        $this->setName('domain:random') // 调用命令名：php think domain:random
        ->setDescription('为域名随机添加支付相关前缀')
            ->addArgument(
                'domains',
                Argument::REQUIRED,
                '用逗号或空格分隔的域名列表，例如：a.com b.com 或 a.com,b.com'
            );
    }

    protected function execute(Input $input, Output $output)
    {
        $domainsStr = $input->getArgument('domains');   // 如：a.com b.com 或 a.com,b.com

        if (empty($domainsStr)) {
            $output->writeln('请输入域名，例如：php think domain:random "a.com b.com" 或 php think domain:random a.com,b.com');
            return;
        }

        // 前缀池
        $prefixes = [
            'checkout',
            'payment',
            'pay',
            'billing',
            'order',
            'purchase',
            'cart',
            'basket',
            'shipping',
            'delivery',
            'address',
            'coupon',
            'voucher',
            'discount',
            'promo',
            'invoice',
            'wallet',
            'credit',
            'debit',
            'deposit',
            'balance',
            'gateway',
            'tracking',
            'confirm',
            'product',
            'quantity',
            'pricing',
            'variant',
            'catalog',
            'inventory',
        ];

        // 支持用逗号或空格分隔：同时拆分 , 和 空白字符
        // 例如： "a.com,b.com c.com , d.com" 都能正常拆分
        $domains = preg_split('/[\s,]+/', $domainsStr);

        $result = [];

        foreach ($domains as $domain) {
            $domain = trim($domain);
            if ($domain === '') {
                continue;
            }

            // 随机取一个前缀
            $randomKey = array_rand($prefixes);
            $prefix = $prefixes[$randomKey];

            $result[] = $prefix . '.' . $domain;
        }

        if (empty($result)) {
            $output->writeln('没有解析到有效域名，请检查输入格式');
            return;
        }

        // 每个结果换行输出
        foreach ($result as $line) {
            $output->writeln($line);
        }
        // 也可以用：$output->writeln(implode(PHP_EOL, $result));
    }
}
