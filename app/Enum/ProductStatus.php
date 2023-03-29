<?php

namespace App\Enum;

class ProductStatus
{
   public const STATUS_OK       = 'OK';
   public const STATUS_WARNING  = 'WARNING';
   public const STATUS_CRITICAL = 'CRITICAL';

   public const NOT_OK_STATUSES = [
     self::STATUS_WARNING,
     self::STATUS_CRITICAL
   ];

   public const ALL_STATUSES = [
     self::STATUS_OK,
     self::STATUS_WARNING,
     self::STATUS_CRITICAL
   ];

   public const QUART = 25;
   public const HALF = 50;
   public const THREE_QUARTER = 75;


}
