<?php

namespace App;

require_once dirname(__DIR__) . '/util/functions.php';

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\VarDumper\VarDumper;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        $container = $this->container;

        try {
            $dumper = $container->get('data_collector.dump');
            $cloner = $container->get('var_dumper.cloner');
        } catch (\Throwable) {
            return;
        }

        VarDumper::setHandler(static fn ($var) => $dumper?->dump($cloner?->cloneVar($var)));
    }
}
