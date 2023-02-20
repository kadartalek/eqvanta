<?php

namespace Kadartalek\Eqvanta;

final class DistancePriceCalculator
{
    /**
     * @var \Kadartalek\Eqvanta\PriceListInterface
     */
    private PriceListInterface $priceList;
    private int $scale;

    public function __construct(PriceListInterface $priceList, int $scale = 4)
    {
        $this->scale     = $scale;
        $this->priceList = $priceList;
    }

    /**
     * @throws \Kadartalek\Eqvanta\DistanceConfigError
     * @throws \InvalidArgumentException
     */
    public function run(int $distance): string
    {
        $old = \bcscale();
        \bcscale($this->scale);
        try {
            return $this->runInternal($distance);
        } finally {
            \bcscale($old);
        }
    }

    /**
     * @throws \Kadartalek\Eqvanta\DistanceConfigError
     * @throws \InvalidArgumentException
     */
    private function runInternal(int $distance): string
    {
        if (0 === $distance) {
            return 0;
        }

        if ($distance < 0) {
            throw new \InvalidArgumentException('Дистанция отрицательная');
        }

        $priceList = $this->priceList;
        $total     = '0';
        $segmentNo = 0;

        $segmentPrice = null;

        /** @var \Kadartalek\Eqvanta\PathSegmentInterface $item */
        foreach ($priceList as $item) {
            ++$segmentNo;
            $segmentLength = $item->segmentLength();
            $segmentPrice  = $item->segmentPrice();

            if ($segmentLength <= 0) {
                throw new DistanceConfigError("Длина отрезка должна быть положительной! #{$segmentNo}; Значение: {$segmentLength}");
            }

            if (1 !== \bccomp($segmentPrice, '0')) {
                throw new DistanceConfigError("Длина отрезка должна быть положительной! #{$segmentNo}; Значение: {$segmentPrice}");
            }

            // Сохраняем остаток дистанции для подсчёта при конце пути
            $distanceLeft = $distance;
            // Вычитаем текущий тарифный отрезок
            $distance -= $segmentLength;

            if ($distance > 0) {
                $total = \bcadd($total, \bcmul($segmentPrice, (string)$segmentLength));
            } else {
                $total = \bcadd($total, \bcmul($segmentPrice, (string)$distanceLeft));
                break;
            }
        }

        if (null === $segmentPrice) {
            throw new DistanceConfigError('Пустой список цен!');
        }

        // Если список цен кончился, а мы не доехали
        if ($distance > 0) {
            // Считаем остаток суммы по цене последнего отрезка
            $total = \bcadd($total, \bcmul($segmentPrice, (string)$distance));
        }

        return $total;
    }
}
