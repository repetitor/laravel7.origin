<?php

/**
 * @OA\Schema(
 *     description="Some simple request createa as example",
 *     type="object",
 *     title="Example storring request",
 * )
 */
class ExampleStoreRequest2
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Some text field",
     *     format="string",
     *     example="11111test"
     * )
     *
     * @var string
     */
    public $name2;

    /**
     * @OA\Property(
     *     title="Value",
     *     description="Some integer",
     *     format="int64",
     *     example="11111"
     * )
     *
     * @var int
     */
    public $value2;
}
