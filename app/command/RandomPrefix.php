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
            ->addArgument('domains', Argument::REQUIRED, '逗号分隔的域名列表，例如：a.com,b.com');
    }

    protected function execute(Input $input, Output $output)
    {
        $domainsStr = $input->getArgument('domains');   // 如：a.com,b.com

        if (empty($domainsStr)) {
            $output->writeln('请输入域名，例如：php think domain:random a.com,b.com');
            return;
        }

        // 前缀池（你给的这堆）
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

        $domains = explode(',', $domainsStr);
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

        // 输出结果
        $output->writeln(implode(',', $result));
    }
}
