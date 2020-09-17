<?php
declare(strict_types=1);

namespace Shampine\Sequence\Response;

use Shampine\Sequence\Support\Str;

trait GetterTrait
{
    /**
     * @param string $property
     * @return mixed|null
     */
    public function __get(string $property)
    {
        $getter = Str::getter($property);

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }
}
