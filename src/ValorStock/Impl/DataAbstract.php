<?php

namespace StockValor\Impl;

abstract class DataAbstract implements DataImpl
{

    public static $DATE_FORMAT_BR = 'd/m/y H:i';
    private string $ticker;
    private int $type;
    private array $currence;
    public function __construct(string $ticker, int $type = 0, array $currence = [1])
    {
        $this->ticker = $ticker;
        $this->type = $type;
        $this->currence = $currence;
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

    public function toData()
    {
        return [
            'ticker'    => $this->getTicker(),
            'type'      => $this->getType(),
            'currences' => $this->getCurrence()

        ];
    }

}