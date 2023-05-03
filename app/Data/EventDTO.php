<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class EventDTO extends Data
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        public int $id,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: self::DATE_FORMAT)]
        public \DateTime $start,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: self::DATE_FORMAT)]
        public \DateTime $end,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: self::DATE_FORMAT)]
        public \DateTime $changed,

        public string $title,
        public array $accepted,
        public array $rejected,
    ){
    }
}
