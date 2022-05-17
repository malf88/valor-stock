<?php

namespace StockValor\Impl;

abstract class DataStatusInvestAbstract implements DataImpl
{


    public function __construct(private string $ticker,
                                private int $type = 0,
                                private array $currence = [1]
    )
    {

    }

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->ticker;
    }

    /**
     * @param string $ticker
     */
    public function setTicker(string $ticker): void
    {
        $this->ticker = $ticker;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getCurrence(): array
    {
        return $this->currence;
    }

    /**
     * @param array $currence
     */
    public function setCurrence(array $currence): void
    {
        $this->currence = $currence;
    }

    public function toData(): array
    {
        return [
            'ticker'    => $this->getTicker(),
            'type'      => $this->getType(),
            'currences' => $this->getCurrence()

        ];
    }

}